<?php

namespace FP\Larmo\Agents\WebHookAgent;

use FP\Larmo\Agents\WebHookAgent\Services\ServiceDataInterface;

class Packet
{
    private $messages;
    private $metadata;
    private $packetArray;

    public function __construct(ServiceDataInterface $service)
    {
        $this->metadata = new Metadata($service->getServiceName());
        $this->messages = $service->getData();
        $this->packetArray = $this->preparePacket();
    }

    private function preparePacket()
    {
        return array(
            'metadata' => $this->metadata->getMetadata(),
            'data' => $this->messages
        );
    }

    public function send()
    {
        $packetJson = json_encode($this->packetArray);
        $this->saveDataToFile($packetJson);
        $this->saveDataAsLog($packetJson);

        return $packetJson;
    }

    private function saveDataToFile($packet)
    {
        $myFile = fopen("output.json", "w+");
        fwrite($myFile, $packet);
        fclose($myFile);
    }

    private function saveDataAsLog($packet)
    {
        file_put_contents("php://stderr", $packet);
    }
}
