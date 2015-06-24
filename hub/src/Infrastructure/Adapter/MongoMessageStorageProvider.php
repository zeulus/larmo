<?php

namespace FP\Larmo\Infrastructure\Adapter;

use FP\Larmo\Domain\Service\FiltersCollection;
use FP\Larmo\Domain\Service\MessageCollection;
use FP\Larmo\Infrastructure\Service\MessageStorageProvider;

class MongoMessageStorageProvider implements MessageStorageProvider {
    private $db;

    public function __construct($config)
    {
        $uri = "mongodb://{$config['db_user']}:{$config['db_password']}@{$config['db_url']}:{$config['db_port']}/{$config['db_name']}";

        try {
            $client = new \MongoClient($uri);
            $this->db = $client->selectDB($config['db_name']);
        } catch(\MongoConnectionException $e) {
            throw new \MongoConnectionException;
        }
    }

    public function store(MessageCollection $messages)
    {
        return $this->db->messages->batchInsert($this->convertMessageCollectionToArray($messages));
    }

    public function setFilters(FiltersCollection $filters)
    {

    }

    public function retrieve(MessageCollection $messages)
    {
        return $this->db->messages->find();
    }

    private function convertMessageCollectionToArray(MessageCollection $messages)
    {
        $outputArray = [];

        foreach($messages as $message) {
            $authorArray = [
                'fullName' => $message->getAuthor()->getFullName(),
                'nickName' => $message->getAuthor()->getNickName(),
                'email' => $message->getAuthor()->getEmail()
            ];

            $messageArray = [
                'messageId' => $message->getMessageId(),
                'type' => $message->getType(),
                'timestamp' => $message->getTimestamp(),
                'author' => $authorArray,
                'body' => $message->getBody(),
                'extras' => $message->getExtras()
            ];

            array_push($outputArray, $messageArray);
        }

        return $outputArray;
    }
}
