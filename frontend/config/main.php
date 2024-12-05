<?php

use yii\rest\UrlRule;
use yii\web\JsonParser;

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
            'parsers' => [
                'application/json' => JsonParser::class,
            ]
        ],
        'response' => [
            'class' => 'yii\web\Response',
            'format' => yii\web\Response::FORMAT_JSON,
            'on beforeSend' => function ($event) {
                $response = $event->sender;
                $response->headers->add('Access-Control-Allow-Origin', '*');
                $response->headers->add('Access-Control-Allow-Headers', 'Content-Type, Authorization');
                $response->headers->add('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
            },
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            //'enableStrictParsing' => false,
            'showScriptName' => false,
            'rules' => [
                'images/<filename>' => 'site/static-image',
                ['class' => UrlRule::class, 'controller' => ['user', 'posts', 'branches']],
                'POST api/login' => 'api/login',
                'POST api/signup' => 'api/signup',
                'POST api/logout' => 'api/logout',
            ],
        ],
    ],
    'params' => $params,
];
