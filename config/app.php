<?php

return [

    'router' => [
        'class' => '\Application\components\Router',
        'routes' => [
            'GET /' => 'storage/index'
        ]
    ],
    'request' => [
        'class' => '\Application\components\Request',
    ]

];