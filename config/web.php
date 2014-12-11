<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'name' => 'Biling',
     /*'import' => array( 
        'application.modules.payments.models.*.*',
        'application.modules.payments.components.*',       
    ),*/
//    'defaultController' => 'site/login',
    /*    'view' => [
      'theme' => [
      'pathMap' => [
      '@app/views' => '@app/themes/classic',
      '@app/modules' => '@app/themes/classic/modules'
      ],
      'baseUrl' => '@web/themes/classic',
      ],
      ], */
    'language'=>'ru-RU',
        'language' => 'ru-RU',
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
        'paypal'=> [
            'class'        => 'ak\Paypal',
            'clientId'     => 'AafqihCLD6RrQKhaE1nB672zsfVDIjRSHtKbmaGzFcSquWJzJ-cL_ISKrKXZ',
            'clientSecret' => 'ECRaAxBG9fgaKCBSIDQ88MwdGYl7fT8iu-NlbiN-jbr3lKf8NoMWwuPW8KeT',
            'isProduction' => false,
            // This is config file for the PayPal system
            'config'       => [
                'http.ConnectionTimeOut' => 30,
                'http.Retry'             => 1,
                'mode'                   => \ak\Paypal::MODE_SANDBOX, // development (sandbox) or production (live) mode
                'log.LogEnabled'         => YII_DEBUG ? 1 : 0,
                'log.FileName'           => '@app/runtime/logs/paypal.log',
                'log.LogLevel'           => \ak\Paypal::LOG_LEVEL_FINE,
            ]
        ],		'cache' => [
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
            'useFileTransport' => false,
        ],
        'pagenService'=>[
            // use пагинация андрея
            'class' => 'app\components\PagenService'
        ],
        'HelpKontrol'=>[
            // use cache андрея
            'class' => 'app\components\HelpKontrol'
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
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [                
                ['pattern' => '<module:\w+>/<controller:\w+>/<action:\w+>', 'route' => '<module>/<controller>/<action>'],
                ['pattern' => 'payments', 'route' => 'payments/default/index'],
            ],
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = 'yii\debug\Module';

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = ['class' => 'yii\gii\Module', 'allowedIPs' => ['*'],];

    $config['components']['log']['targets'][] = [
        'class' => 'yii\log\FileTarget',
        'levels' => ['info'],
        'categories' => ['userMessage'],
        'logFile' => '@app/runtime/logs/messages/messages.log',
        'maxFileSize' => 1024 * 2,
        'maxLogFiles' => 20,
    ];
}

$config['modules'] ['payments'] = [
    'class' => 'app\modules\payments\Module',
];
return $config;
