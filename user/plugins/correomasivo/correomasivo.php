<?php
namespace Grav\Plugin;

use Grav\Common\Plugin;
use RocketTheme\Toolbox\Event\Event;
use ZendXml\Exception\RuntimeException;

/**
 * Class CorreomasivoPlugin
 * @package Grav\Plugin
 */
class CorreomasivoPlugin extends Plugin {
    /**
     * @return array
     *
     * The getSubscribedEvents() gives the core a list of events
     *     that the plugin wants to listen to. The key of each
     *     array section is the event that the plugin listens to
     *     and the value (in the form of an array) contains the
     *     callable (or function) as well as the priority. The
     *     higher the number the higher the priority.
     */
    public static function getSubscribedEvents() {
        return [
            'onPluginsInitialized' => ['onPluginsInitialized', 0],
            'onFormProcessed' => ['onFormProcessed', 0]
        ];
    }

    private function randomPassword() {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }

    private function split_name($string) {
        $arr = explode(' ', $string);
        $num = count($arr);

        if ($num == 2) {
            return list($f, $l) = $arr;
        }

        if ($num == 3) {
            list($f, $m, $l) = $arr;
            $j = $f . " " . $m;
            return array($j, $l);
        }
        if ($num == 5){
            list($f, $m, $l, $lsec) = $arr;
            return array($f . " " . $m, $l . " " . $lsec);
        }else{
            throw new \Exception("necesita agregar el nombre completo");
        }


    }

    public function onFormProcessed(Event $event) {
        $data = $event['form']->value();
        $this->grav['debugger']->addMessage($data);

        $this->grav['debugger']->addMessage($data->items);
        dump($data);

        $form = $event['form'];
        $action = $event['action'];
        switch ($action) {
            case 'whm':
                $this->grav['debugger']->addMessage("nombre");
                $this->grav['debugger']->addMessage($data->items['nombre']);


                $url = "http://netquatro.co/miportal/includes/api.php"; # URL to WHMCS API file
                $results = null;

                $postfields["username"] = 'superadminnetq25';
                $postfields["accesskey"] = 'qu3rtiP4ssC0ntr0lCL4v3';
                $postfields["password"] = md5('18yooDp9cUKfYdWVpPa');
                $postfields["action"] = "addclient"; #action performed by the [[API:Functions]]

                list($nombres, $apellidos) = $this->split_name($data->items['nombre']);
                $empresa = $data->items['empresa'];
                $nombre_completo = $nombres . " " . $apellidos;
                $correo = $data->items['correo'];
                $telefono = $data->items['telefono'];
                $celular = $data->items['celular'];
                $comentario   = $data->items['comentario'];
                $requerimiento = $data->items['requerimiento'] == 'default' ? "solicitar informacion" : "habilitar demo";

                $postfields["firstname"] = $nombres;
                $postfields["lastname"] = $apellidos;
                $postfields["companyname"] = $empresa;
                $postfields["email"] = $correo;
                $postfields["address1"] = "";
                $postfields["city"] = "";
                $postfields["state"] = "";
                $postfields["postcode"] = "";
                $postfields["country"] = "VE";
                $postfields["phonenumber"] = $telefono;
                $postfields["password2"] = $this->randomPassword();
                $postfields["customfields"] = base64_encode(serialize(array("1" => $celular)));

                try {

                    //------creamos el usuario en el whmcs---------------------------------------------------------
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_TIMEOUT, 100);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
                    curl_exec($ch);
                    curl_close($ch);
                    
                    
                    //--------enviamos el correo usando el manejador de correo-------------------------------------
                    $curl = curl_init('https://netquatro.ip-zone.com/ccm/admin/api/version/2/&type=json');


                    $rcpt = array(
                        /* array(
                             'name' => 'Bernardo',
                             'email' => 'bernardo.murillo@netquatro.com'
                         ),
                         array(
                             'name' => 'Daniel',
                             'email' => 'daniel.perez@netquatro.com'
                         ),*/
                        array(
                            'name' => null,
                            'email' => 'carlos.laguna@netquatro.com'
                        )
                    );


                    $postData = array(
                        'function' => 'sendMail',
                        'apiKey' => 'sqlmciqiHk1eCglxFENNTiHShwxJU72CoepGDVpK',
                        'subject' => 'NET4EMAIL: Contacto cliente',
                        'html' => "
                        <html>
                            <head><title>Info</title></head>
                            <body>
                                <h1>Hola...el cliente:  $nombre_completo de la empresa: $empresa esta interesado en net4email </h1>
                                <h2>Desea $requerimiento</h2>
                                <h3>Contacto</h3>
                                <h4>Telefonos: $telefono , $celular </h4>
                                <h4>Correo:  $correo</h4> 
                                <h4>comentario: $comentario</h4>
                                       
                           </body></html>",
                        'mailboxFromId' => 1,
                        'mailboxReplyId' => 1,
                        'mailboxReportId' => 1,
                        'packageId' => 6,
                        'emails' => $rcpt
                    );

                    $post = http_build_query($postData);

                    curl_setopt($curl, CURLOPT_POST, true);
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

                    $json = curl_exec($curl);
                    if ($json === false) {
                        die('Request failed with error: ' . curl_error($curl));
                    }

                    $result = json_decode($json);
                    if ($result->status == 0) {
                        die('Bad status returned. Error: ' . $result->error);
                    }

                    var_dump($result->data);


                    curl_close($curl);

                } catch (Exception $e) {
                    var_dump($e);
                    $this->grav['debugger']->addMessage("ERR: " . json_encode($e));

                }
        }
    }

    /**
     * Initialize the plugin
     */
    public function onPluginsInitialized() {
        // Don't proceed if we are in the admin plugin
        if ($this->isAdmin()) {
            return;
        }

        // Enable the main event we are interested in
        $this->enable([
                          'onPageContentRaw' => ['onPageContentRaw', 0]
                      ]);
    }

    /**
     * Do some work for this event, full details of events can be found
     * on the learn site: http://learn.getgrav.org/plugins/event-hooks
     *
     * @param Event $e
     */
    public function onPageContentRaw(Event $e) {
        // Get a variable from the plugin configuration
        $text = $this->grav['config']->get('plugins.correomasivo.text_var');

        // Get the current raw content
        $content = $e['page']->getRawContent();

        // Prepend the output with the custom text and set back on the page
        $e['page']->setRawContent($text . "\n\n" . $content);
    }
}
