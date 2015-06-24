<?php

namespace FP\Larmo\Domain\Entity;

use FP\Larmo\Domain\Service\UniqueIdGenerator;
use FP\Larmo\Domain\ValueObject\Author;

class Message
{

    private $messageId;
    private $type;
    private $timestamp;
    private $author;
    private $body;
    private $extras;

    public function __construct($type, $timestamp, Author $author, UniqueIdGenerator $generator, $body = '', $extras = array())
    {
        $this->type = $type;
        $this->timestamp = $timestamp;
        $this->author = $author;
        $this->body = $body;
        $this->extras = $extras;

        $this->messageId = $generator->generate();
    }

    public function getType()
    {
        return $this->type;
    }

    public function getTimestamp()
    {
        return $this->timestamp;
    }

    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;
    }

    public function getAuthor()
    {
        return $this->author;
    }

    public function getMessageId()
    {
        return $this->messageId;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function getExtras()
    {
        return $this->extras;
    }
}