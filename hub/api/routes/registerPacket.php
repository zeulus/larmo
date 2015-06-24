<?php

use Symfony\Component\HttpFoundation\Request;

$app->post('/registerPacket', function (Request $request) use ($app) {
    $jsonContent = $request->getContent();
    $packet = $app['json_parse']($jsonContent);

    if (!$packet) {
        return $app->json(['message' => 'Invalid JSON structure']);
    }

    if (!isset($packet['metadata'])) {
        return $app->json(['message' => 'Metadata doesn\'t exists']);
    }

    if (!isset($packet['data'])) {
        return $app->json(['message' => 'Data doesn\'t exists']);
    }

    if (!isset($packet['metadata']['authinfo']) || !$app['authinfo']->validate($packet['metadata']['authinfo'])) {
        return $app->json(['message' => 'Invalid authinfo']);
    }

    if (!isset($packet['metadata']['source']) || !$app['plugins']->checkPluginIsRegistered($packet['metadata']['source'])) {
        return $app->json(['message' => 'Invalid source']);
    }

    $messages = $app['messages.factory']->fromArray($packet['data']);
    $app['messages.repository']->store($messages);

    return $app->json(['message' => 'OK']);
});