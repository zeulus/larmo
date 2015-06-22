<?php
/**
 * Created by PhpStorm.
 * User: mlabedowicz
 * Date: 2015-06-22
 * Time: 14:23
 */

namespace FP\Larmo\Agents\WebHookAgent\Services;

use FP\Larmo\Agents\WebHookAgent\Exceptions\EventTypeNotFoundException;
use FP\Larmo\Agents\WebHookAgent\Exceptions\ServiceNotFoundException;

class ServiceFactory
{
    static public function create($serviceName, $data)
    {
        try {
            /* Caution: full namespace path is necessary for class_exists() to work correctly */
            $serviceClass = "\\FP\\Larmo\\Agents\\WebHookAgent\\Services\\" . ucfirst($serviceName) . "\\" . ucfirst($serviceName) . "Data";

            if (!class_exists($serviceClass)) {
                throw new ServiceNotFoundException;
            } else {
                return new $serviceClass($data);
            }
        } catch (EventTypeNotFoundException $e) {
            throw new EventTypeNotFoundException;
        } catch (ServiceNotFoundException $e) {
            throw new ServiceNotFoundException;
        } catch (Exception $e) {
            file_put_contents("php://stderr", $e->getMessage());
            throw new Exception("Service could not be created for unknown reason");
        }
    }
}