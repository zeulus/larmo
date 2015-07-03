<?php

namespace FP\Larmo\Agents\WebHookAgent\Services\Bitbucket\Events;

use FP\Larmo\Agents\WebHookAgent\Services\EventInterface;

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
