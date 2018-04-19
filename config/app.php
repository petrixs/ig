<?php

return [

    'router' => [
        'class' => '\Application\components\Router',
        'controllerNamespace' => '\Application\controllers',
        'routes' => [
            'GET /' => 'storage/index'
        ]
    ],
    'request' => [
        'class' => '\Application\components\Request',
    ]

];