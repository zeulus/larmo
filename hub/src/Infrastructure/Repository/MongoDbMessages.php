<?php

namespace FP\Larmo\Infrastructure\Adapter;

use FP\Larmo\Domain\ValueObject\UniqueId;
use FP\Larmo\Domain\Service\FiltersCollection;
use FP\Larmo\Domain\Service\MessageCollection;
use FP\Larmo\Infrastructure\Factory\Message as MessageFactory;
use FP\Larmo\Infrastructure\Repository\Messages as MessageRepository;

class MongoDbMessage implements MessageRepository
{
    private $storage;
    private $filters;
    private $collectionName = 'messages';

    public function __construct(MongoDbStorage $storage)
    {
        $this->storage = $storage;
    }

    public function store(MessageCollection $messages)
    {
        return $this->storage->batchInsert($this->collectionName, $this->convertMessageCollectionToArray($messages));
    }

    /**
     * @param MessageCollection $messages
     * @param FiltersCollection $filters
     * @return MessageCollection
     */
    public function retrieve(MessageCollection $messages, FiltersCollection $filters = null)
    {
        // @todo: use message collection factory
        // @todo: set filters: ...->setFilters($filters);

        $retrieved = $this->storage->find($this->collectionName);

        foreach ($retrieved as $message) {
            $uniqueId = new UniqueId($message['messageId']);
            $messageFactory = new MessageFactory($uniqueId);
            $messages[] = $messageFactory->fromArray($message);
        }

        return $messages;
    }

    private function convertMessageCollectionToArray(MessageCollection $messages)
    {
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

        return $outputArray;
    }
}
