<?php

use FP\Larmo\GHAgent\Packet;

class PacketTest extends PHPUnit_Framework_TestCase {
    private $message;

    public function setup() {
        $this->message = "";
        $this->packet = new Packet('push', $this->message);
    }
}
