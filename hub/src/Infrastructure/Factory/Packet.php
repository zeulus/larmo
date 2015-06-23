<?php

namespace FP\Larmo\Infrastructure\Factory;

class Packet
{
    public function fromJson($packetJSON)
    {
        $packet = json_decode($packetJSON, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception("Invalid JSON structure");
        }

        return $packet;
    }
}