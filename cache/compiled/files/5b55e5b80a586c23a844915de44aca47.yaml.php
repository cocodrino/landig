<?php
return [
    '@class' => 'Grav\\Common\\File\\CompiledYamlFile',
    'filename' => '/home/netquatro/Descargas/landingpage/1/landig/user/config/plugins/email.yaml',
    'modified' => 1478524438,
    'data' => [
        'enabled' => true,
        'from' => 'correosmasivos@netquatro.com',
        'from_name' => 'correo masivo',
        'to' => 'correosmasivos@netquatro.com',
        'to_name' => 'correo masivo',
        'mailer' => [
            'engine' => 'mail',
            'smtp' => [
                'server' => 'mail.netquatro.com',
                'port' => 25,
                'encryption' => 'none',
                'user' => 'correosmasivos',
                'password' => 'correosmasivos0q*'
            ]
        ],
        'content_type' => 'text/html',
        'debug' => true
    ]
];
