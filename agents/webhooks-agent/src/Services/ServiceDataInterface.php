<?php

namespace FP\Larmo\Agents\WebHookAgent\Services;

interface ServiceDataInterface
{
    public function __construct($data, $requestHeaders = null);

    public function getData();

    public function getServiceName();
}