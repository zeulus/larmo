<?php

use fkooman\Json\Json;
use Symfony\Component\HttpFoundation\Request;

$app->post('/registerPacket', function (Request $request) use ($app) {
    $content = $request->getContent();
    $response = ['message' => 'OK'];

    try {
        if ($content) {
            Json::decode($content);
        } else {
            $response['message'] = "Empty content";
        }
    } catch (InvalidArgumentException $exception) {
        $response['message'] = $exception->getMessage();
    }

    return $app->json($response);
});