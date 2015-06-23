<?php

namespace FP\Larmo\Agents\WebHookAgent\Services\Bitbucket;

use FP\Larmo\Agents\WebHookAgent\Request;
use FP\Larmo\Agents\WebHookAgent\Services\ServiceAbstract;
use FP\Larmo\Agents\WebHookAgent\Services\ServiceDataInterface;
use FP\Larmo\Agents\WebHookAgent\Services\Bitbucket\Events;
use FP\Larmo\Agents\WebHookAgent\Exceptions\EventTypeNotFoundException;

class BitbucketData extends ServiceAbstract
{
    public function __construct($data, $requestHeaders = null)
    {
        $this->serviceName = 'bitbucket';
        $this->eventHeader = 'HTTP_X_EVENT_KEY';
        $this->eventType = $this->getEventType($requestHeaders);
        $this->data = $this->prepareData($data);
    }

    protected function prepareData($data)
    {
        if (!empty($this->eventType)) {
            switch ($this->eventType) {
                case "repo:push":
                    $event = new Events\Push($data);
                    $messages = $event->getMessages();
                    break;
                default:
                    throw new EventTypeNotFoundException;
                    break;
            }

            return $messages;
        } else {
            throw new \InvalidArgumentException;
        }
    }
}
