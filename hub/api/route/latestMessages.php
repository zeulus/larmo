<?php

use Symfony\Component\HttpFoundation\Request;

$app->get('/latestMessages', function (Request $request) use ($app) {
    $jsonContent = $request->getContent();
    $content = json_decode($jsonContent, true);
    $filters = $app['filters.service'];

    if(is_array($content)) {
        $filters->addFilters($content);
    }

    $messages = $app['messages.repository']->retrieve($filters);

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