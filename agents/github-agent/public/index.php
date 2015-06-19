<?php

require_once('../vendor/autoload.php');

use FP\Larmo\GHAgent\Request;
use FP\Larmo\GHAgent\Packet;

if(Request::isPostMethod()) {
    try {
        $packet = new Packet(Request::getEventType(), Request::getMessage());
        $packet->send();
    } catch(InvalidArgumentException $e) {
        http_response_code(404);
        echo $e;
    }
} else {
    http_response_code(405);
}
