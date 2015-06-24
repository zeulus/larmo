<?php

$app->get('/latestMessages', function () use ($app) {
    $messages = [];

    return $app->json($messages);
});