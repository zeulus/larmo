<?php

use FP\Larmo\Message;
use FP\Larmo\Author;

class MessageTest extends PHPUnit_Framework_TestCase {

    private $message;
    private $author;

    public function setup() {
        $this->author = new Author;
        $this->message = new Message('irc', 'aaaa', $this->author);
    }

    /**
     * @test
     */
    public function messageHasType() {
        $this->assertNotEmpty($this->message->getType());
    }

    /**
     * @test
     */
    public function messageTypeIsValid() {
        $this->assertEquals('irc', $this->message->getType());
    }

    /**
     * @test
     */
    public function messageHasTimestamp() {
        $this->assertNotEmpty($this->message->getTimestamp());
    }

    /**
     * @test
     */
    public function unixTimestampIsInteger() {
        $this->setExpectedException('InvalidArgumentException');
        $this->message->setTimestamp('dfjshdshgfkjids');
    }

    /**
     * @test
     * @depends unixTimestampIsInteger
     */
    public function unixTimestampIsPositiveNumber() {
        $this->setExpectedException('InvalidArgumentException');
        $this->message->setTimestamp(-2);
    }

    /**
     * @test
     */
    public function messageHaveAuthorData() {
        $this->assertTrue($this->message->getAuthor() instanceof \FP\Larmo\Author);
    }
}