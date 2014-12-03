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
    'components' => [
        'language'=>'ru-RU',
        'i18n' => [
            'translations' => [
                '*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/messages',
                    'sourceLanguage' => 'en',
                    'fileMap' => [
                        //'main' => 'main.php',
                    ],
                ],
            ],
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'shfhgjfh637yghhgfbhgghjhn',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'authManager' => [
            'class' => 'yii\rbac\PhpManager',
//            'authFile' => '@app/config/rbac.php'

            'defaultRoles' => ['superadmin', 'admin', 'manager', 'user','quest'],
/*            'itemFile' => '@app/components/rbac/items.php',
            'assignmentFile' => '@app/components/rbac/assignments.php',
            'ruleFile' => '@app/components/rbac/rules.php'*/
            ],
 /*       'authManager' => [
            'class' => \Zelenin\yii\modules\Rbac\components\DbManager::className(),
            'itemFile' => '@common/config/rbac/items.php',
            'assignmentFile' => '@common/config/rbac/assignments.php',
            'ruleFile' => '@common/config/rbac/rules.php',
            'defaultRole' => 'user',
            'roleParam' => 'role', // User model attribute
            // optional
            'enableCaching' => false,
            'cachingDuration' => 60
        ],*/
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
