<?php

return [

    'router' => [
        'class' => '\Application\components\Router',
        'controllerNamespace' => '\Application\controllers',
        'routes' => [
            'GET /' => 'storage/index'
        ],
        'view' => [
            'class' => '\Application\components\Twig',
            'templateDir' => ['views'],
            'params' => [
                'cache' => "cache",
                'auto_reload' => true
            ]
        ]
    ],

    'request' => [
        'class' => '\Application\components\Request'
    ],

];