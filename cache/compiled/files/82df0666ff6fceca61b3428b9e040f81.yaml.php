<?php
return [
    '@class' => 'Grav\\Common\\File\\CompiledYamlFile',
    'filename' => '/home/netquatro/Descargas/landingpage/1/landig/user/plugins/correomasivo/blueprints.yaml',
    'modified' => 1478524438,
    'data' => [
        'name' => 'Correomasivo',
        'version' => '0.1.0',
        'description' => 'usa correomasivo en vez del correo de php',
        'icon' => 'plug',
        'author' => [
            'name' => 'yo',
            'email' => 'yo@yo.com'
        ],
        'homepage' => 'https://github.com/yo/grav-plugin-correomasivo',
        'demo' => 'http://demo.yoursite.com',
        'keywords' => 'grav, plugin, etc',
        'bugs' => 'https://github.com/yo/grav-plugin-correomasivo/issues',
        'docs' => 'https://github.com/yo/grav-plugin-correomasivo/blob/develop/README.md',
        'license' => 'MIT',
        'form' => [
            'validation' => 'strict',
            'fields' => [
                'enabled' => [
                    'type' => 'toggle',
                    'label' => 'Plugin status',
                    'highlight' => 1,
                    'default' => 0,
                    'options' => [
                        1 => 'Enabled',
                        0 => 'Disabled'
                    ],
                    'validate' => [
                        'type' => 'bool'
                    ]
                ],
                'text_var' => [
                    'type' => 'text',
                    'label' => 'Text Variable',
                    'help' => 'Text to add to the top of a page'
                ]
            ]
        ]
    ]
];
