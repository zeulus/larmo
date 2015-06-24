<?php

namespace FP\Larmo\Agents\WebHookAgent\Services\Gitlab;

use FP\Larmo\Agents\WebHookAgent\Services\ServiceAbstract;

class GitlabData extends ServiceAbstract
{
    public function __construct($data, $requestHeaders = null)
    {
        $this->serviceName = 'gitlab';
        $this->eventHeader = 'X-Gitlab-Event';
        $this->eventType = $data->object_kind;
        $this->data = $this->prepareData($data);
    }
}
