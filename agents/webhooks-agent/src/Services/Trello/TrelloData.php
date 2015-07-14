<?php

namespace FP\Larmo\Agents\WebHookAgent\Services\Trello;

use FP\Larmo\Agents\WebHookAgent\Services\ServiceAbstract;

class TrelloData extends ServiceAbstract
{
    public function __construct($data, $requestHeaders = null)
    {
        $this->serviceName = 'trello';
        $this->eventHeader = 'HTTP_X_EVENT_KEY';
        $this->eventType = $this->getEventType($requestHeaders);
        $this->data = $this->prepareData($data);
    }
}