<?php

namespace FP\Larmo\Agents\WebHookAgent;

class Packet {
    private $messages;
    private $metadata;
    private $packetArray;

    public function __construct($messages) {
        $this->metadata = new Metadata();
        $this->messages = $messages;
        $this->packetArray = $this->preparePacket();
    }

    private function preparePacket() {
         return array(
            'metadata' => $this->metadata->getMetadata(),
            'data' => $this->messages
        );
    }

    public function send() {
        $packetJson = json_encode($this->packetArray);
        $this->saveDataToFile($packetJson);
        $this->saveDataAsLog($packetJson);

        return $packetJson;
    }

    private function saveDataToFile($packet) {
        $myFile = fopen("output.json", "w+");
        fwrite($myFile, $packet);
        fclose($myFile);
    }

    private function saveDataAsLog($packet) {
        file_put_contents("php://stderr", $packet);
    }
}
