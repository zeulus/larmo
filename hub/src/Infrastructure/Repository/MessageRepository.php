<?php

namespace FP\Larmo\Infrastructure\Repository;

use FP\Larmo\Domain\Service\FiltersCollection;
use FP\Larmo\Domain\Service\MessageCollection;
use FP\Larmo\Infrastructure\Service\MessageStorageProvider;

class MessageRepository
{

    /**
     * @var MessageStorageProvider
     */
    private $storage;

    /**
     * @param MessageStorageProvider $storage
     */
    public function __construct(MessageStorageProvider $storage)
    {
        $this->storage = $storage;
    }

    /**
     * @param MessageCollection $messages
     */
    public function store(MessageCollection $messages)
    {

        $this->storage->store($messages);
    }

    /**
     * @param FiltersCollection $filters
     * @return MessageCollection
     */
    public function retrieve(FiltersCollection $filters)
    {

        $this->storage->setFilters($filters);

        $messages = new MessageCollection();
        $this->storage->retrieve($messages);

        return $messages;
    }
}