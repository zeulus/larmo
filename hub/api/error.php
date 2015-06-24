<?php

$app->error(function (Exception $exception) use ($app) {
    if ($app['debug']) {
        return;
    }

    $response = ['message' => $exception->getMessage()];

    return $app->json($response);
});