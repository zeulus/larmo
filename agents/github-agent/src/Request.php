<?php

namespace FP\Larmo\GHAgent;

class Request {
    public static function isPostMethod() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            return true;
        }

        return false;
    }

    public static function getMessage() {
        return file_get_contents('php://input');
    }

    public static function getEventType() {
        foreach (self::getHeaders() as $name => $value) {
            if($name === 'X-GitHub-Event') {
                return $value;
            }
        }

        return null;
    }

    private static function getHeaders() {
        if(function_exists('getallheaders')) {
            return getallheaders();
        } else {
            $headers = '';

            foreach ($_SERVER as $name => $value)
            {
                if (substr($name, 0, 5) == 'HTTP_')
                {
                    $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
                }
            }

            return $headers;
        }
    }
}
