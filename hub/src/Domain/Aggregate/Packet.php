<?php

namespace FP\Larmo\Domain\Aggregate;

use FP\Larmo\Domain\Entity\Metadata;
use FP\Larmo\Domain\Service\MessageCollection;

class Packet
{

    private $messages;
    private $metadata;

    public function __construct(MessageCollection $messages, Metadata $metadata)
    {
        $this->messages = $messages;
        $this->metadata = $metadata;
    }

    public function getMessages()
    {
        return $this->messages;
    }

    public function getMetadata()
    {
        return $this->metadata;
    }

}