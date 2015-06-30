<?php

$app->get('/latestMessages', function (Request $request) use ($app) {
    $jsonContent = $request->getContent();

    $filters = $app['filters.service'](json_decode($jsonContent, true));
    $messages = $app['messages.repository']->retrieve($filters);

    return $app->json($messages);
});