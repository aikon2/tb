<?php

//Заменить все _%... на текущие

return [
    'class' => 'yii\db\Connection',    
    'dsn' => 'mysql:host=localhost;dbname=_%ИмяБазыДанных',
    'username' => '_%Пользователь_',
    'password' => '_%ПарольПользователя_',
    'charset' => 'utf8',
];

