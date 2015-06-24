<?php

use fkooman\Json\Json;
use Symfony\Component\HttpFoundation\Request;

$app->post('/registerPacket', function (Request $request) use ($app) {
    function parseJson($content) {
        try {
            if ($content) {
                return Json::decode($content);
            } else {
                return false;
            }
        } catch (InvalidArgumentException $exception) {
            return false;
        }
    }

    $jsonContent = $request->getContent();
    $packet = parseJson($jsonContent);

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

    //if (!isset($packet['metadata']['source']) || $packet['metadata']['source'] != 'github') {
    //    return $app->json(['message' => 'Invalid source']);
    //}

    return $app->json(['message' => 'OK']);
});