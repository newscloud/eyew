<?php
  global $config;
$config = parse_ini_file('/var/secure/eyew.ini', true);
$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'modules' => [
        'user' => [
            'class' => 'dektrium\user\Module',
        ],
    ],
    'components' => [
    /* remove user???
      'user' => [
          'identityClass' => 'app\models\User',
          'enableAutoLogin' => true,
      ],*/
    
        'authClientCollection' => [
                'class' => 'yii\authclient\Collection',
                'clients' => [
                  'google' => [
                                  'class' => 'yii\authclient\clients\GoogleOpenId'
                              ],
                                  'instagram' => [
                            'class' => 'kotchuprik\authclient\Instagram',
                              'clientId' => $config['instagram_client_id'] ,
                              'clientSecret' => $config['instagram_client_secret'] ,
                            ],
                    ],
                ],
        'urlManager' => [
                  'showScriptName' => false,
                  'enablePrettyUrl' => true
                          ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '4EcLUuTYznQCf35HBc8TeD9Qhi4gsgIy',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
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
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = 'yii\debug\Module';

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = 'yii\gii\Module';
}

return $config;
