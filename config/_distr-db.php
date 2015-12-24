<?php

//Заменить все _%... на текущие

return [
    'class' => 'yii\db\Connection',    
    'dsn' => 'mysql:host=localhost;dbname=_%ИмяБазыДанных',
    'username' => '_%Пользователь_',
    'password' => '_%ПарольПользователя_',
    'charset' => 'utf8',
    'enableSchemaCache' => true,
    // Продолжительность кеширования схемы.
    'schemaCacheDuration' => 3600,
    // Название компонента кеша, используемого для хранения информации о схеме
    'schemaCache' => 'cache',
];

