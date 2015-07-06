<?php

namespace FP\Larmo\Infrastructure\Repository;

use FP\Larmo\Domain\ValueObject\UniqueId;
use FP\Larmo\Domain\Service\FiltersCollection;
use FP\Larmo\Domain\Service\MessageCollection;
use FP\Larmo\Domain\Repository\Messages as MessagesRepository;

use FP\Larmo\Infrastructure\Adapter\MongoDbStorage;
use FP\Larmo\Infrastructure\Factory\Message as MessageFactory;

class MongoDbMessages implements MessagesRepository
{
    private $storage;
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
            $uniqueId = new UniqueId($message['id']);
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
                'id' => $message->getMessageId(),
                'source' => explode('.', $message->getType())[0],
                'type' => $message->getType(),
                'timestamp' => $message->getTimestamp(),
                'author' => [
                    'name' => $message->getAuthor()->getFullName(),
                    'login' => $message->getAuthor()->getNickName(),
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
