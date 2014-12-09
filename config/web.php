<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'name' => 'Biling',
//    'defaultController' => 'site/login',
/*    'view' => [
        'theme' => [
            'pathMap' => [
                '@app/views' => '@app/themes/classic',
                '@app/modules' => '@app/themes/classic/modules'
            ],
            'baseUrl' => '@web/themes/classic',
        ],
    ],*/
    'language'=>'ru-RU',
    'components' => [
        'i18n' => [
            'translations' => [
                '*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/messages',
                    'sourceLanguage' => 'en-US',
                    'fileMap' => [
                        //'app' => 'app.php',
                        //'app/error' => 'error.php',
                    ],
                ],
            ],
        ],
		'urlManager' => [
			'enablePrettyUrl' => true,
			'showScriptName' => false,
			'class'=>'app\components\LangUrlManager',
			'rules'=>[
				'/' => 'site/index',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			]
		],
		'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'shfhgjfh637yghhgfbhgghjhn',
			'class' => 'app\components\LangRequest'
        ],
        'image' => [
            'class' => 'yii\image\ImageDriver',
            'driver' => 'GD', //GD or Imagick
        ],
        'response' => [
            'formatters' => [
                'pdf' => [
                    'class' => 'robregonm\pdf\PdfResponseFormatter',
                ],
            ]
        ],
        // Yii2 TCPDF
        'tcpdf' => [
            'class' => 'cinghie\tcpdf\TCPDF',
        ],
		'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'authManager' => [
//            'class' => 'yii\rbac\PhpManager',
            'class' => 'yii\rbac\DbManager',
            'defaultRoles' => [
                'user',
                'manager',
                'admin',
                'superadmin'
            ],
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
    $config['modules']['gii'] = ['class' => 'yii\gii\Module', 'allowedIPs' => ['*'],];
}

return $config;
