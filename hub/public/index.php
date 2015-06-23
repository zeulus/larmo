<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$app = new Application();

$app['debug'] = true;

$app->post('/registerPacket', function (Request $request) use ($app) {
    $content = $request->getContent();
    $response = ["status" => "OK"];

    return new Response(json_encode($response));
});

$app->get('/latestMessages', function () use ($app) {
    $messages = [];

    return new Response(json_encode($messages));
});

$app->get('/availableSources', function () use ($app) {
    $sources = [
        ["id" => "skype", "label" => "Skype"],
        ["id" => "irc", "label" => "IRC"],
        ["id" => "github", "label" => "GitHub"]
    ];

    return new Response(json_encode($sources));
});

$app->error(function (\Exception $exception) use ($app) {
    if ($app['debug']) {
        return;
    }

    return $exception->getMessage();
});

$app->run();