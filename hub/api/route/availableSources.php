<?php

$app->get('/availableSources', function () use ($app) {
    $sources = [
        ['id' => 'skype', 'label' => 'Skype'],
        ['id' => 'irc', 'label' => 'IRC'],
        ['id' => 'github', 'label' => 'GitHub'],
        ['id' => 'gitlab', 'label' => 'GitLab'],
        ['id' => 'bitbucket', 'label' => 'Bitbucket'],
    ];

    return $app->json($sources);
});