<?php

namespace FP\Larmo\Agents\WebHookAgent\Services\Bitbucket;

interface EventInterface
{
    /**
     * @param $data
     */
    public function __construct($data);

    /**
     * @return array() - Array contains messages ready to send
     */
    public function getMessages();
}
