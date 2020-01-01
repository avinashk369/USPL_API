<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'modules' => [],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'sod',
            'enableCsrfValidation'=>false,
            'parsers'=>['application/json'=>'yii\web\JsonParser'],
        ],
        'response' => [
                'format' => yii\web\Response::FORMAT_JSON,
                'charset' => 'UTF-8',
                // ...
            ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
                         'class' => 'yii\swiftmailer\Mailer',
                         'viewPath' => '@app/mail',
                         'transport' => [
                             'class' => 'Swift_SmtpTransport',
                             'host' => '162.251.85.8',  
                             'username' => 'admin@dipsonpolymers.in',
                             'password' => 'admin@123',
                             'port' => '587',
                            'encryption' => 'tls', 
                             'streamOptions' => [ 'ssl' => [ 'allow_self_signed' => true, 'verify_peer' => false, 'verify_peer_name' => false, ], ]

                         ],
                        //'viewPath' => '@common/mail',
                     ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            /*'rules' => [
                [
                'class' => 'yii\rest\UrlRule',
                'controller' => 'user', 
                'pluralize' => false,
                'tokens' => ['{id}' => '<id:\\w+>'],
                'extraPatterns'=> 
                                [
                                // string with verb has nothing to do with the url it can be anything but the value assigned to this verb is the key that yii url manager try to find in your controller class if that is there it will redirect to that class file and rest of action will be performed there.

                                    'GET  viewUser'=>'index', 
                                    'GET  show'=>'show',
                                ],
                
                ],
                [
                'class' => 'yii\rest\UrlRule',
                'controller' => 'service', 
                'pluralize' => false,
                'tokens' => ['{id}' => '<id:\\w+>'],
                'extraPatterns'=> 
                                [
                                // string with verb has nothing to do with the url it can be anything but the value assigned to this verb is the key that yii url manager try to find in your controller class if that is there it will redirect to that class file and rest of action will be performed there.
                                
                                    'GET  show'=>'show',
                                ],
                
               
                ],
            ],*/
        ],
        
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
