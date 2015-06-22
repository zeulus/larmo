<?php

require_once('../vendor/autoload.php');

use FP\Larmo\Agents\WebHookAgent\Packet;
use FP\Larmo\Agents\WebHookAgent\Request;
use FP\Larmo\Agents\WebHookAgent\Routing;
use FP\Larmo\Agents\WebHookAgent\Services;
use FP\Larmo\Agents\WebHookAgent\Services\ServiceFactory;
use FP\Larmo\Agents\WebHookAgent\Exceptions\MethodNotAllowedHttpException;
use FP\Larmo\Agents\WebHookAgent\Exceptions\ServiceNotFoundException;
use FP\Larmo\Agents\WebHookAgent\Exceptions\EventTypeNotFoundException;

header("Content-type: application/json; charset=utf-8");

try {
    if (!Request::isPostMethod()) {
        throw new MethodNotAllowedHttpException;
    }

    /* Retrieve data from HTTP request */
    $uri = Request::getUri();
    $postData = json_decode(Request::getPostData());

    /* Create appropriate service */
    $routing = new Routing($uri);
    $service = ServiceFactory::create($routing->getSourceIdentifier(),$postData);

    /* Create and send packet */
    $packet = new Packet($service);
    $packet->send();
} catch (MethodNotAllowedHttpException $e) {
    http_response_code(405); // POST only allowed
} catch (EventTypeNotFoundException $e) {
    http_response_code(400); // We got an event type we are not prepared to handle
} catch (ServiceNotFoundException $e) {
    http_response_code(404); // We do not have the ability to handle this service
} catch (InvalidArgumentException $e) {
    http_response_code(404);
} catch (Exception $e) {
    /* Unpredicted error */
    file_put_contents('php://stderr', $e->getMessage());
}
