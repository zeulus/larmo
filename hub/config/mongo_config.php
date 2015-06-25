<?php

$defaultValues = [
    'db_user' => getenv('MONGO_DB_USER'),
    'db_password' => getenv('MONGO_DB_PASSWORD'),
    'db_url' => getenv('MONGO_DB_URL'),
    'db_name' => getenv('MONGO_DB_NAME'),
    'db_port' => getenv('MONGO_DB_PORT')
];

if(file_exists(__DIR__ . '/parameters.php')) {
    require_once __DIR__ . '/parameters.php';

    if(isset($configParameters) && is_array($configParameters) && array_key_exists('mongo_db', $configParameters)) {
        $defaultValues = $configParameters['mongo_db'];
    }
}

$app['mongo_db'] = $defaultValues;
