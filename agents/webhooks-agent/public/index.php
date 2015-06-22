<?php

require_once('../vendor/autoload.php');

use FP\Larmo\Agents\WebHookAgent\Packet;
use FP\Larmo\Agents\WebHookAgent\Request;
use FP\Larmo\Agents\WebHookAgent\Services;

header("Content-type: application/json; charset=utf-8");

if(Request::isPostMethod()) {
    $uri = Request::getUri();
    $postData = json_decode(Request::getPostData());

    switch($uri) {
        case '/github':
            try {
                $service = new Services\Github\GithubData($postData);
            } catch(Exception $e) {
                file_put_contents("php://stderr", $e->getMessage());
            }
            break;
        case '/gitlab':
            $service = "";
            break;
        default:
            http_response_code(405);
            die();
            break;
    }

    try {
        $packet = new Packet($service->getData());
        $packet->send();
    } catch(InvalidArgumentException $e) {
        http_response_code(404);
    }
} else {
    http_response_code(405);
}
