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
        $cleansedUri = trim(str_replace("http://", "", $this->uri));

        /* Verify whether URI ends in "/" and cut it out if needed */
        if (mb_substr($cleansedUri, -1) === "/") {
            $uriToSegmentate = mb_substr($cleansedUri, 0, strlen($cleansedUri) - 1);
        } else {
            $uriToSegmentate = $cleansedUri;
        }

        /* Extract identifier - last segment of the URI */
        $uriSegments = explode("/", $uriToSegmentate);
        if (!empty($uriSegments)) {
            $finalUriSegment = array_pop($uriSegments);
        } else {
            $finalUriSegment = null;
        }

        return $finalUriSegment;
    }
}