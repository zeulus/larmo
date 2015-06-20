<?php

namespace FP\Larmo\Domain\Entity;

use FP\Larmo\Domain\Service\AuthInfoInterface;

class Metadata
{

    private $timestamp;
    private $authInfo;
    private $source;
    private $authInfoValidator;

    public function __construct(AuthInfoInterface $authInfoValidator, $timestamp, $authInfo, $source)
    {
        $this->authInfoValidator = $authInfoValidator;
        $this->timestamp = $timestamp;
        $this->authInfo = $authInfo;
        $this->source = $source;
    }

    public function getTimestamp()
    {
        return $this->timestamp;
    }

    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;
    }

    public function setAuthInfo($authInfo)
    {
        if ($this->authInfoValidator->validate($authInfo)) {
            $this->authInfo = $authInfo;
        } else {
            throw new \InvalidArgumentException("AuthInfo is not valid");
        }
    }

    public function getAuthInfo()
    {
        return $this->authInfo;
    }

    public function getSource()
    {
        return $this->source;
    }

    public function setSource($source)
    {
        $this->source = $source;
    }

}
