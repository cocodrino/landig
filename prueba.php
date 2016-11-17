<?php
$curl = curl_init('https://netquatro.ip-zone.com/ccm/admin/api/version/2/&type=json');

// Create rcpt array to send emails to 2 rcpts
$rcpt = array(
    array(
        'name' => 'Miguel',
        'email' => 'miguel.medina@netquatro.com'
    ),
    array(
        'name' => null,
        'email' => 'carlos.laguna@netquatro.com'
    )
);

$postData = array(
    'function' => 'sendMail',
    'apiKey' => 'sqlmciqiHk1eCglxFENNTiHShwxJU72CoepGDVpK',
    'subject' => 'Mensaje de prueba',
    'html' => '<html><head><title>Hola</title></head><body><h1>Hola desde el correo</h1></body></html>',
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
    die('Request failed with error: '. curl_error($curl));
}

$result = json_decode($json);
if ($result->status == 0) {
    die('Bad status returned. Error: '. $result->error);
}
