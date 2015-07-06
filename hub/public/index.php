<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$app = new Silex\Application;

$app->after(function (Request $request, Response $response) {
    $response->headers->set('Access-Control-Allow-Origin', '*');
});

require_once __DIR__ . '/../api/config.php';
require_once __DIR__ . '/../api/dic.php';
require_once __DIR__ . '/../api/routes.php';
require_once __DIR__ . '/../api/error.php';

$app->run();