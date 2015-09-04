<?php

use FP\Larmo\Domain\Service\LarmoEvents;
use FP\Larmo\Application\Event\IncomingMessageEvent;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$app->post('/registerPacket', function (Request $request) use ($app) {
    $packetDataAsObject = json_decode($request->getContent());
    $packetDataAsArray = json_decode($request->getContent(), true);

    $packetValidation = $app['packet_validation.service']->setSchemaFromFile($app['config.path.packet_scheme'])
        ->setPacket($packetDataAsObject);

    if ($packetValidation->isValid()) {
        // transform messages from packet to domain collection
        $messages = $app['messages.factory']->fromArray($packetDataAsArray['data']);

        $event = new IncomingMessageEvent();
        $event->setMessages($messages);

        $app['dispatcher']->dispatch(LarmoEvents::INCOMING_MESSAGE, $event);

        if ($event->hasErrors()) {
            return $app->json(['message' => $event->getErrors()], Response::HTTP_BAD_REQUEST);
        } else {
            return $app->json(['message' => 'OK'], Response::HTTP_OK);
        }
    } else {
        return $app->json(['message' => $packetValidation->getErrors()], Response::HTTP_BAD_REQUEST);
    }
});