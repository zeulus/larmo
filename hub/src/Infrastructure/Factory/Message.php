<?php

namespace FP\Larmo\Infrastructure\Factory;

use FP\Larmo\Domain\Entity;
use FP\Larmo\Domain\ValueObject\Author;
use FP\Larmo\Domain\ValueObject\UniqueId;
use FP\Larmo\Infrastructure\Adapter\PhpUniqidGenerator;

class Message
{
    public function fromArray($message)
    {
        $type = isset($message['type']) ? $message['type'] : '';
        $timestamp = isset($message['timestamp']) ? $message['timestamp'] : '';
        $body = isset($message['body']) ? $message['body'] : '';
        $extras = isset($message['extras']) ? $message['extras'] : '';

        if (isset($message['author'])) {
            $authorFullName = isset($message['author']['name']) ? $message['author']['name'] : '';
            $authorNickName = isset($message['author']['login']) ? $message['author']['login'] : '';
            $authorEmail = isset($message['author']['email']) ? $message['author']['email'] : '';

            $author = new Author($authorFullName, $authorNickName, $authorEmail);
        } else {
            $author = new Author();
        }

        $uniqueId = new UniqueId(isset($message['id']) ? $message['id'] : new PhpUniqidGenerator());

        return new Entity\Message($type, $timestamp, $author, $uniqueId, $body, $extras);
    }
}