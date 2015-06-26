<?php

namespace FP\Larmo\Infrastructure\Adapter;

use FP\Larmo\Domain\Service\FiltersCollection;
use FP\Larmo\Domain\Service\MessageCollection;
use FP\Larmo\Domain\ValueObject\UniqueId;
use FP\Larmo\Infrastructure\Service\MessageStorageProvider;
use FP\Larmo\Infrastructure\Factory\Message as FactoryMessage;

class MongoMessageStorageProvider implements MessageStorageProvider {
    private $db;

    public function __construct($config)
    {
        $credentials = '';
        if(isset($config['db_user']) && isset($config['db_password'])) {
            $credentials = "{$config['db_user']}:{$config['db_password']}@";
        }

        $uri = "mongodb://{$credentials}{$config['db_url']}:{$config['db_port']}/{$config['db_name']}";

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
        $messagesArray = $this->db->messages->find();
        foreach($messagesArray as $message) {
            $uniqueId = new UniqueId($message['messageId']);
            $messageFactory = new FactoryMessage($uniqueId);
            $messages[] = $messageFactory->fromArray($message);
        }
    }

    private function convertMessageCollectionToArray(MessageCollection $messages)
    {
        $outputArray = [];

        foreach($messages as $message) {
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

        return $outputArray;
    }
}
