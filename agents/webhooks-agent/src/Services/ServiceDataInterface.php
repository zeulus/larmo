<?php

namespace FP\Larmo\Agents\WebHookAgent\Services;

interface ServiceDataInterface
{
    public function __construct($data);

    public function getData();

    public function getServiceName();
}