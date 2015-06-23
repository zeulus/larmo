<?php

namespace FP\Larmo\Agents\WebHookAgent;

use FP\Larmo\Agents\WebHookAgent\Services\ServiceDataInterface;

class Packet
{
    private $packetArray;

    public function __construct($metadataObject, ServiceDataInterface $service)
    {
        $metadata = $metadataObject->getMetadata();
        $messages = $service->getData();
        $this->packetArray = $this->preparePacket($metadata, $messages);
    }

    private function preparePacket($metadata, $messages)
    {
        return array(
            'metadata' => $metadata,
            'data' => $messages
        );
    }

    public function send()
    {
        $packetJson = json_encode($this->packetArray);
        $this->saveDataAsLog($packetJson);

        return $packetJson;
    }

    private function saveDataAsLog($packet)
    {
        file_put_contents("php://stderr", $packet);
    }
}
