<?php

namespace FP\Larmo\Domain\Entity;

use FP\Larmo\Domain\Service\ChecksumInterface;
use FP\Larmo\Domain\Service\AuthInfoInterface;

class Metadata {

    private $checksum;
    private $timestamp;
    private $authInfo;
    private $source;
    private $checksumValidator;
    private $authInfoValidator;

    public function __construct(ChecksumInterface $checksumValidator, AuthInfoInterface $authInfoValidator, $checksum, $timestamp, $authInfo, $source) {
        $this->checksumValidator = $checksumValidator;
        $this->authInfoValidator = $authInfoValidator;
        $this->checksum = $checksum;
        $this->timestamp = $timestamp;
        $this->authInfo = $authInfo;
        $this->source = $source;
    }

    public function getChecksum() {
        return $this->checksum;
    }

    public function setChecksum($checksum) {
        if ($this->checksumValidator->validate($checksum)) {
            $this->checksum = $checksum;
        } else {
            throw new \InvalidArgumentException("Checksum is incorrect");
        }
    }

    public function getTimestamp() {
        return $this->timestamp;
    }

    public function setTimestamp($timestamp) {
        $this->timestamp = $timestamp;
    }

    public function setAuthInfo($authInfo) {
        if ($this->authInfoValidator->validate($authInfo)) {
            $this->authInfo = $authInfo;
        } else {
            throw new \InvalidArgumentException("AuthInfo is not valid");
        }
    }

    public function getAuthInfo() {
        return $this->authInfo;
    }

    public function getSource() {
        return $this->source;
    }

    public function setSource($source) {
        $this->source = $source;
    }

}
