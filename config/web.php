<?php

$params = require(__DIR__ . '/params.php');
$db = require(__DIR__ . '/db.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
     'modules' => [
        'user' => [
            'class' => 'dektrium\user\Module',
            'admins' => ['jbudzik94@gmail.com', 'joanna30000@onet.pl'],
           // 'modelMap' => [
           //     'User' => 'app\models\User',
           // ],
            'enableAccountDelete' => 'true',


           /**'controllerMap' => [
                'registration' => [
                    'class' => \dektrium\user\controllers\RegistrationController::className(),
                    'on ' . \dektrium\user\controllers\RegistrationController::EVENT_AFTER_CONFIRM=> function ($e) {
                        $userId = \Yii::$app->user->getId();
                       // $doctor = \app\models\Doctor::find()->where(['user_id' => $userId])->exists();

                       // $role = UserDetails::find()->where(['user_id'=>$userId])->one()->role;

                        $role = \app\models\UserDetails::find(['user_id' => $userId])->one()->role;
                        //$doctorId = $doctor->id;
                        if($role == 'pacjent'){
                            Yii::$app->response->redirect(array('/site/about'))->send();
                            Yii::$app->end();
                        }
                        else{
                           Yii::$app->response->redirect(array('/site/contact'))->send();
                            Yii::$app->end();
                        }

                    }
                ],
            ],*/

        ],
    ],
    'components' => [

        // Overriding existing User extension's view
        /*'view' => [
            'theme' => [
                'pathMap' => [
                    '@dektrium/user/views' => '@app/views/user'
                ],
            ],
        ],*/
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'L1xNjCXGl9lAFyIksOBvqANllXqP1VIn',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
       // 'user' => [
       //     'identityClass' => 'app\models\User',
       //     'enableAutoLogin' => true,

       // ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.gmail.com',
                'username' => 'jbudzik94@gmail.com',
                'password' => 'highroller1',
                'port' => '587',
                'encryption' => 'tls',

            ],

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
        'db' => $db,
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['language'] = 'pl';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
