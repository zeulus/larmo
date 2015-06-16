<?php

namespace FP\Larmo\Domain\Service;


class Packet {

    private $messages;

    public function __construct(MessageCollection $messages) {
        $this->messages = $messages;
    }

    public function getMessages() {
        return $this->messages;
    }

}