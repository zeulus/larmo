<?php

namespace FP\Larmo\Domain\Entity;
use FP\Larmo\Application\Service\UniqueIdGenerator;
use FP\Larmo\Domain\ValueObject\Author;

class Message {

    private $messageId;
    private $type;
    private $timestamp;
    private $author;

    public function __construct($type, $timestamp, Author $author, UniqueIdGenerator $generator) {
        $this->type = $type;
        $this->timestamp = $timestamp;
        $this->author = $author;

        $this->messageId = $generator->generate();
    }

    public function getType() {
        return $this->type;
    }

    public function getTimestamp() {
        return $this->timestamp;
    }

    public function setTimestamp($timestamp) {
            $this->timestamp = $timestamp;
    }

    public function getAuthor() {
        return $this->author;
    }

    public function getMessageId() {
        return $this->messageId;
    }
}