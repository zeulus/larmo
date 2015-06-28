<?php

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

$app->post('/registerPacket', function (Request $request) use ($app) {
    $packetDataAsObject = json_decode($request->getContent());
    $packetDataAsArray = json_decode($request->getContent(), true);

    $packetValidation = $app['packet_validation.service']->setSchemaFromFile($app['packet_scheme'])
        ->setPacket($packetDataAsObject);

    if ($packetValidation->isValid()) {
        // transform messages from packet to domain collection
        $messages = $app['messages.factory']->fromArray($packetDataAsArray['data']);

        // store messages
        $app['messages.repository']->store($messages);

        return $app->json(['message' => 'OK'], Request::HTTP_OK);

    } else {
        return $app->json(['message' => $packetValidation->getErrors()], Response::HTTP_BAD_REQUEST);
    }
});