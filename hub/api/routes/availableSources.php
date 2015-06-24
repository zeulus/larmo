<?php

$app->get('/availableSources', function () use ($app) {
    $sources = [
        ['id' => 'skype', 'label' => 'Skype'],
        ['id' => 'irc', 'label' => 'IRC'],
        ['id' => 'github', 'label' => 'GitHub']
    ];

    return $app->json($sources);
});