<?php

namespace FP\Larmo\GHAgent;

class Packet {
    private $messages;
    private $metadata;
    private $packetArray;

    public function __construct($eventType, $data) {
        $this->metadata = new Metadata();
        $this->messages = $this->prepareMessages($eventType, $data);
        $this->packetArray = $this->preparePacket();
    }

    private function prepareMessages($eventType, $data) {
        if($eventType) {
            switch($eventType) {
                case "push":
                    $event = new Events\Push($data);
                    $messages = $event->getMessages();
                    break;
                default:
                    throw new \InvalidArgumentException;
                    break;
            }

            return $messages;
        }

        throw new \InvalidArgumentException;
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

        return $packetJson;
    }

    private function saveDataToFile($packet) {
        $myFile = fopen("output.json", "w+");
        fwrite($myFile, $packet);
        fclose($myFile);
    }
}
