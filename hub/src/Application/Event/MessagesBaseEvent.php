<?php

namespace FP\Larmo\Application\Event;

use FP\Larmo\Domain\Service\MessageCollection;
use Symfony\Component\EventDispatcher\Event;

abstract class MessagesBaseEvent extends Event
{

    /**
     * @var MessageCollection
     */
    private $messages;

    /**
     * @var array
     */
    private $errors = [];

    /**
     * @param MessageCollection $messages
     */
    public function setMessages(MessageCollection $messages)
    {
        $this->messages = $messages;
    }

    /**
     * @return MessageCollection
     */
    public function getMessages()
    {
        return $this->messages;
    }

    /**
     * @param string $message
     */
    public function setError($message)
    {
        $this->errors[] = $message;
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @return bool
     */
    public function hasErrors()
    {
        return (count($this->errors) > 0);
    }
}