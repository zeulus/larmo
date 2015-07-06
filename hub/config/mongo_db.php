<?php

$app['config.mongo_db'] = [
    'db_user' => getenv('MONGO_DB_USER'),
    'db_password' => getenv('MONGO_DB_PASSWORD'),
    'db_url' => getenv('MONGO_DB_URL'),
    'db_name' => getenv('MONGO_DB_NAME'),
    'db_port' => getenv('MONGO_DB_PORT'),
    'db_options' => []
];