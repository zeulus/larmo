<?php

namespace FP\Larmo\Infrastructure\Factory;

use FP\Larmo\Domain\Service\MessageCollection as DomainMessageCollection;
use FP\Larmo\Infrastructure\Adapter\PhpUniqidGenerator;

class MessageCollection
{
    public function fromArray($messages)
    {
        $generator = new PhpUniqidGenerator();
        $messageCollection = new DomainMessageCollection;
        $messageFactory = new Message($generator);

        foreach($messages as $message) {
            $messageCollection[] = $messageFactory->fromArray($message);
        }

        return $messageCollection;
    }
}