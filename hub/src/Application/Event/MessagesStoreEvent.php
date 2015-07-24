<?php

namespace FP\Larmo\Application\Event;

use FP\Larmo\Domain\Service\MessageCollection;
use Symfony\Component\EventDispatcher\Event;

final class MessagesStoreEvent extends Event
{

    /**
     * @var MessageCollection
     */
    private $messages;

    public function setMessages(MessageCollection $messages)
    {
        $this->messages = $messages;
    }

    public function getMessages()
    {
        return $this->messages;
    }
}