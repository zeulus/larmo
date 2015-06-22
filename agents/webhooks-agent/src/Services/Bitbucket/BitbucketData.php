<?php

namespace FP\Larmo\Agents\WebHookAgent\Services\Bitbucket;

use FP\Larmo\Agents\WebHookAgent\Request;
use FP\Larmo\Agents\WebHookAgent\Services\ServiceDataInterface;
use FP\Larmo\Agents\WebHookAgent\Services\Bitbucket\Events;
use FP\Larmo\Agents\WebHookAgent\Exceptions\EventTypeNotFoundException;

class BitbucketData implements ServiceDataInterface
{
    private $data;
    private $serviceName;

    public function __construct($data)
    {
        $this->serviceName = 'bitbucket';
        $this->data = $this->prepareData($data);
    }

    private function prepareData($data)
    {
        $eventType = strtolower(Request::getValueFromHeaderByKey("HTTP_X_EVENT_KEY"));

        if (!empty($eventType)) {
            switch ($eventType) {
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

    public function getData()
    {
        return $this->data;
    }

    public function getServiceName()
    {
        return $this->serviceName;
    }
}
