<?php

//Заменить все _%... на текущие

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'tisbasic',
    'language' => 'ru-RU', //Русский язык
    'sourceLanguage' => 'ru-RU', //Русский язык приложения
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'components' => [
        //Добавим секцию urlManager для нормального отображения пути, а не %
        'urlManager' => [
            'showScriptName' => false,
            'enablePrettyUrl' => true
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '_%СекретныйКлюч',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => false,
            'messageConfig' => [
                'charset'=>'UTF-8',
            ],                                    
            //Следующий при использовании другого почтового сервера
            /*'transport'=>[
                'class'=>'Swift_SmtpTransport',
                'host'=>'_%SmtpСервер',
                'username'=>'_%ИмяПользователя',
                'password'=>'_%Пароль',
                'port'=>'25',                
            ],*/
        ],
        
        ///
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
        'session' => [
            'class' => 'yii\web\DbSession',
            // Установите следующее, если вы хотите использовать компонент БД, с названием
            // отличным от значения по умолчанию 'db'.
            // 'db' => 'mydb',
            // Чтобы перезаписать таблицу сессий, заданную по умолчанию, установите
            // 'sessionTable' => 'my_session',
        ],        
        'authManager' => [
          'class' => 'yii\rbac\DbManager',
          'cache' => 'cache' //Включаем кеширование
        ],
    ],
    
    'params' => $params,
    
    ///
];

if (YII_ENV_DEV) {
    // настройка конфигурации для окружения 'dev'
    //Для конкретных IP: 'allowedIPs' => ['127.0.0.1', '::1', '192.168.0.*', '192.168.178.20']
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

