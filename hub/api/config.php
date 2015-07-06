<?php

$config = __DIR__ . '/../config/';

require_once $config . 'env.php';
require_once $config . 'path.php';
require_once $config . 'mongo_db.php';

if (file_exists($config . 'parameters.php')) {
    require_once $config . 'parameters.php';
}