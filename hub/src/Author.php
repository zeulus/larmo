<?php

namespace FP\Larmo;

class Author {

    const DEFAULT_DISPLAY_NAME = 'Anonim';

    private $fullName;
    private $nickName;
    private $email;

    public function __construct($fullName = '', $nickName = '', $email = '') {
        $this->fullName = $fullName;
        $this->nickName = $nickName;
        $this->email = $email;
    }

    public function getDisplayName() {
        if ($this->getFullName()) {
            return $this->getFullName();
        } else if ($this->nickName) {
            return $this->nickName;
        } else if ($this->getEmail()) {
            return $this->getEmail();
        }

        return self::DEFAULT_DISPLAY_NAME;
    }

    public function getFullName() {
        return $this->fullName;
    }

    public function getEmail() {
        return $this->email;
    }
}