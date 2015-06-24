<?php

namespace FP\Larmo\Agents\WebHookAgent\Services\Github\Events;

use FP\Larmo\Agents\WebHookAgent\Services\Github\EventInterface;

abstract class EventAbstract implements EventInterface
{
    private $messages;

    public function __construct($data)
    {
        $this->messages = $this->prepareMessages($data);
    }

    public function getMessages()
    {
        return $this->messages;
    }

    abstract protected function prepareMessages($data);
}