<?php

namespace FP\Larmo\Agents\WebHookAgent;

use FP\Larmo\Agents\WebHookAgent\Exceptions\InvalidIncomingDataException;

class Request
{
    private $server;
    private $payload;

    public function __construct(array $server, $payload = "")
    {
        $this->server = $server;
        $this->payload = $payload;
    }

    public function isPostMethod()
    {
        return $this->server['REQUEST_METHOD'] === 'POST';
    }

    public function getUri()
    {
        return $this->server['REQUEST_URI'];
    }

    public function getPayload()
    {
        return $this->payload;
    }

    public function getDecodedPayload()
    {
        $decodedData = json_decode($this->payload);

        if ($decodedData === null) {
            throw new InvalidIncomingDataException;
        } else {
            return $decodedData;
        }
    }

    public function getHeaders()
    {
        return $this->server;
    }
}
