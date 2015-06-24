<?php

$app['mongo_db'] = array(
    'db_user' => $_ENV['MONGO_DB_USER'],
    'db_password' => $_ENV['MONGO_DB_PASSWORD'],
    'db_url' => $_ENV['MONGO_DB_URL'],
    'db_name' => $_ENV['MONGO_DB_NAME'],
    'db_port' => $_ENV['MONGO_DB_PORT']
);
