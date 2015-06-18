<?php

use FP\Larmo\Domain\Entity\Metadata;

class MetadataTest extends PHPUnit_Framework_TestCase {

    private $metadata;
    private $checkSumValidator;
    private $authInfoValidator;

    public function setup() {
        $this->checkSumValidator = $this->getMockBuilder('\FP\Larmo\Domain\Service\CheckSumInterface')->setMethods(array('validate'))->getMock();
        $this->authInfoValidator = $this->getMockBuilder('\FP\Larmo\Domain\Service\AuthInfoInterface')->setMethods(array('validate'))->getMock();
        $this->metadata = new Metadata($this->checkSumValidator, $this->authInfoValidator, time(), 'AUTH_INFO', 'SOME_SOURCE');
    }

    /**
     * @test
     */
    public function checksumIsNotValidating() {
        $this->checkSumValidator->method('validate')->willReturn(false);
        $this->setExpectedException('InvalidArgumentException');
        $this->metadata->setChecksum("CHECKSUM");
    }

    /**
     * @test
     */
    public function checksumIsSetCorrectly() {
        /* We must assume checksum is correct */
        $this->checkSumValidator->method('validate')->willReturn(true);

        $this->metadata->setChecksum("SET OLD");
        $csOriginal = $this->metadata->getChecksum();

        $this->metadata->setChecksum("SET NEW");
        $csNew = $this->metadata->getChecksum();

        $this->assertNotEquals($csOriginal,$csNew);
    }

    /**
     * @test
     */
    public function metadataHasTimestamp() {
        $this->assertNotEmpty($this->metadata->getTimestamp());
    }

    /**
     * @test
     */
    public function metadataTimestampIsSetCorrectly() {
        $time = time();
        $this->metadata->setTimestamp($time);
        $this->assertEquals($time, $this->metadata->getTimestamp());
    }

    /**
     * @test
     */
    public function metadataHasAuthInfo() {
        $this->assertNotEmpty($this->metadata->getAuthInfo());
    }

    /**
     * @test
     */
    public function metadataCanSetAuthInfo() {
        $this->authInfoValidator->method('validate')->willReturn(true);
        $this->metadata->setAuthInfo('AUTHENTICATION INFO');
        $this->assertEquals('AUTHENTICATION INFO',$this->metadata->getAuthInfo());
    }

    /**
     * @test
     */
    public function authInfoIsNotValidating() {
        $this->authInfoValidator->method('validate')->willReturn(false);
        $this->setExpectedException('InvalidArgumentException');
        $this->metadata->setAuthInfo("NEW AUTH INFO");
    }

    /**
     * @test
     */
    public function metadataHasSource() {
        $this->assertNotEmpty($this->metadata->getSource());
    }

    /**
     * @test
     */
    public function metadataSourceIsSetCorrectly() {
        $this->metadata->setSource("SOURCE_IRC");
        $irc = $this->metadata->getSource();

        $this->metadata->setSource("SOURCE_GIT");
        $git = $this->metadata->getSource();

        $this->assertNotEquals($irc, $git);
    }

}
