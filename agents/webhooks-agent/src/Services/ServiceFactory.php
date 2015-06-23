<?php

namespace FP\Larmo\Agents\WebHookAgent\Services;

use FP\Larmo\Agents\WebHookAgent\Exceptions\EventTypeNotFoundException;
use FP\Larmo\Agents\WebHookAgent\Exceptions\ServiceNotFoundException;

class ServiceFactory
{
    static public function create($serviceName, $request)
    {
        try {
            /* Caution: full namespace path is necessary for class_exists() to work correctly */
            $serviceClass = '\\FP\\Larmo\\Agents\\WebHookAgent\\Services\\' . ucfirst($serviceName) . '\\' . ucfirst($serviceName) . 'Data';

            if (!class_exists($serviceClass)) {
                throw new ServiceNotFoundException;
            }

            return new $serviceClass($request->getDecodedPayload(), $request->getHeaders());
        } catch (EventTypeNotFoundException $e) {
            throw $e;
        } catch (ServiceNotFoundException $e) {
            throw $e;
        } catch (Exception $e) {
            file_put_contents('php://stderr', $e->getMessage());
            throw new Exception('Service could not be created for unknown reason', $e->getCode(), $e);
        }
    }
}