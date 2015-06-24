<?php

$app->error(function (Exception $exception) use ($app) {
    if ($app['debug']) {
        return;
    }

    return $app->json(['message' => $exception->getMessage()]);
});