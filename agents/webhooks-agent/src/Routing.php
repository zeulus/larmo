<?php

namespace FP\Larmo\Agents\WebHookAgent;

class Routing
{
    private $uri;

    public function __construct($uri)
    {
        $this->uri = $uri;
    }

    public function getSourceIdentifier()
    {
        $cleansedUri = parse_url($this->uri, PHP_URL_PATH);
        $finalUriSegment = basename($cleansedUri);
        return $finalUriSegment;
    }
}