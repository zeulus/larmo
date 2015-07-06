<?php

namespace FP\Larmo\Infrastructure\Factory;

use FP\Larmo\Domain\Service\MessageCollection as DomainMessageCollection;
use FP\Larmo\Infrastructure\Adapter\PhpUniqidGenerator;
use FP\Larmo\Domain\ValueObject\UniqueId;

class MessageCollection
{
    public function createEmptyCollection()
    {
        return $this->fromArray([]);
    }

    public function fromArray($messages)
    {
        $generator = new PhpUniqidGenerator();
        $messageCollection = new DomainMessageCollection;
        $messageFactory = new Message(new UniqueId($generator));

        foreach($messages as $message) {
            $messageCollection[] = $messageFactory->fromArray($message);
        }

        return $messageCollection;
    }
}