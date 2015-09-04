<?php

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Whoops\Provider\Silex\WhoopsServiceProvider;

if ($app['debug']) {
    $app->register(new WhoopsServiceProvider);
}

$app->before(function (Request $request, Application $app) {
    // this is required to fire off plugin service and load plugin info
    $app['plugins'];
});

$app->after(function (Request $request, Response $response) {
    $response->headers->set('Access-Control-Allow-Origin', '*');
});