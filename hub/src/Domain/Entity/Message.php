<?php

namespace FP\Larmo\Domain\Entity;

use FP\Larmo\Domain\ValueObject\Author;
use FP\Larmo\Domain\ValueObject\UniqueId;

class Message
{

    private $messageId;
    private $type;
    private $timestamp;
    private $author;
    private $body;
    private $extras;

    public function __construct($type, $timestamp, Author $author, UniqueId $uniqueId, $body = '', $extras = array())
    {
        $this->type = $type;
        $this->timestamp = $timestamp;
        $this->author = $author;
        $this->body = $body;
        $this->extras = $extras;
        $this->messageId = $uniqueId->getId();
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