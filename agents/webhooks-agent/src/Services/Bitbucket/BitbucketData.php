<?php

namespace FP\Larmo\Agents\WebHookAgent\Services\Bitbucket;

use FP\Larmo\Agents\WebHookAgent\Services\ServiceAbstract;
use FP\Larmo\Agents\WebHookAgent\Services\Bitbucket\Events;

class BitbucketData extends ServiceAbstract
{
    public function __construct($data, $requestHeaders = null)
    {
        $this->serviceName = 'bitbucket';
        $this->eventHeader = 'HTTP_X_EVENT_KEY';
        $this->eventType = $this->getEventType($requestHeaders);
        $this->data = $this->prepareData($data);
    }

    protected function getEventClass()
    {
        $eventType = str_replace(':','_',$this->eventType);
        $eventTypeArray = explode('_', $eventType);
        $eventClassPath = '\\FP\\Larmo\\Agents\\WebHookAgent\\Services\\' . ucfirst($this->serviceName) . '\\Events\\';
        return $eventClassPath . implode('', array_map('ucfirst', $eventTypeArray));
    }
}
