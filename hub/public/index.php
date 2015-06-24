<?php

require_once __DIR__ . '/../vendor/autoload.php';

$app = new Silex\Application;

require_once __DIR__ . '/../config/env.php';
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/mongo_config.php';

require_once __DIR__ . '/../api/dic.php';
require_once __DIR__ . '/../api/routes.php';
require_once __DIR__ . '/../api/error.php';

$app->run();