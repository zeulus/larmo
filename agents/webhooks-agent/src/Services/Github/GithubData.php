<?php

namespace FP\Larmo\Agents\WebHookAgent\Services\Github;

use FP\Larmo\Agents\WebHookAgent\Request;
use FP\Larmo\Agents\WebHookAgent\Services\ServiceDataInterface;
use FP\Larmo\Agents\WebHookAgent\Services\Github\Events;

class GithubData implements ServiceDataInterface
{
    private $data;
    private $serviceName;

    public function __construct($data)
    {
        $this->serviceName = 'github';
        $this->data = $this->prepareData($data);
    }

    private function prepareData($data)
    {
        $eventType = strtolower(Request::getValueFromHeaderByKey("HTTP_X_GITHUB_EVENT"));

        if ($eventType) {
            switch ($eventType) {
                case "push":
                    $event = new Events\Push($data);
                    break;

                case "commit_comment":
                    $event = new Events\CommitComment($data);
                    break;

                default:
                    throw new \InvalidArgumentException;
                    break;
            }

            return $event->getMessages();
        }

        throw new \InvalidArgumentException;
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