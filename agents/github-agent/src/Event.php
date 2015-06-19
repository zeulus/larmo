<?php

namespace FP\Larmo\GHAgent;

interface Event {
    public function __construct($data);
    public function getMessages();
}
