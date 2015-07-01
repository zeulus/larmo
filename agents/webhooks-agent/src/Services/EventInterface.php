<?php

namespace FP\Larmo\Agents\WebHookAgent\Services;

interface EventInterface
{
    /**
     * @param $data
     */
    public function __construct($data);

    /**
     * @return array - Array contains massages ready to send
     */
    public function getMessages();
}
