<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$app->get('/latestMessages', function (Request $request) use ($app) {
    $filters = $app['filters.service'];

    try {
        $filters->addFilters($request->query->all());
    } catch (\InvalidArgumentException $e) {
        return $app->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
    }

    $messages = $app['messages.factory']->createEmptyCollection();
    $app['messages.repository']->retrieve($messages, $filters);

    $outputArray = [];

    foreach ($messages as $message) {
        $messageArray = [
            'messageId' => $message->getMessageId(),
            'source' => explode('.', $message->getType())[0],
            'type' => $message->getType(),
            'timestamp' => $message->getTimestamp(),
            'author' => [
                'fullName' => $message->getAuthor()->getFullName(),
                'nickName' => $message->getAuthor()->getNickName(),
                'email' => $message->getAuthor()->getEmail()
            ],
            'body' => $message->getBody(),
            'extras' => $message->getExtras()
        ];

        array_push($outputArray, $messageArray);
    }

    return $app->json($outputArray);
});