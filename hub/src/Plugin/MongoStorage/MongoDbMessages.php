<?php

namespace FP\Larmo\Plugin\MongoStorage;;

use FP\Larmo\Domain\ValueObject\UniqueId;
use FP\Larmo\Domain\Service\FiltersCollection;
use FP\Larmo\Domain\Service\MessageCollection;
use FP\Larmo\Domain\Repository\Messages as MessagesRepository;

use FP\Larmo\Infrastructure\Factory\Message as MessageFactory;

final class MongoDbMessages implements MessagesRepository
{
    private $storage;
    private $collectionName = 'messages';
    private $defaultSortBy = 'timestamp';

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

        $findQuery = $this->prepareQuery($filters->getFilter('data'));

        $retrieved = $this->storage->find($this->collectionName, $findQuery);

        if ($filters->hasFilter('limit')) {
            $retrieved->limit($filters->getFilter('limit'));
        }

        if ($filters->hasFilter('offset')) {
            $retrieved->skip($filters->getFilter('offset'));
        }

        $retrieved->sort(array($this->defaultSortBy => -1));

        foreach ($retrieved as $message) {
            $uniqueId = new UniqueId($message['id']);
            $messageFactory = new MessageFactory($uniqueId);
            $messages[] = $messageFactory->fromArray($message);
        }

        return $messages;
    }

    private function prepareQuery($data)
    {
        $query = array();
        foreach ($data as $field => $value) {
            if (is_array($value)) {
                $query[$field] = array('$in' => $value);
            } else {
                $query[$value] = $value;
            }
        }
        return $query;
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
