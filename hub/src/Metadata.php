<?php

namespace FP\Larmo;

use Symfony\Component\Yaml\Tests\A;

class Metadata {

    private $checksum;
    private $timestamp;
    private $authInfo;
    private $source;

    public function __construct(CheckSumInterface $csv, AuthInfoInterface $aiv, $checksum, $timestamp, $authInfo, $source) {
        $this->csv = $csv;
        $this->aiv = $aiv;
        $this->checksum = $checksum;
        $this->timestamp = $timestamp;
        $this->authInfo = $authInfo;
        $this->source = $source;
    }

    public function getChecksum() {
        return $this->checksum;
    }

    public function setChecksum($checksum) {
        if ($this->csv->validate($checksum)) {
            $this->checksum = $checksum;
        } else {
            throw new \Exception("Checksum is incorrect");
        }
    }

    public function getTimestamp() {
        return $this->timestamp;
    }

    public function setTimestamp($timestamp) {
        if(is_int($timestamp) && $timestamp >= 0) {
            $this->timestamp = $timestamp;
        } else {
            throw new \InvalidArgumentException;
        }
    }

    public function setAuthInfo($authInfo) {
        if ($this->aiv->validate($authInfo)) {
            $this->authInfo = $authInfo;
        } else {
            throw new \Exception("AuthInfo is not valid");
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