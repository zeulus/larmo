<?php

use FP\Larmo\Domain\Entity\Message;
use FP\Larmo\Domain\ValueObject\Author;
use FP\Larmo\Domain\ValueObject\UniqueId;
use FP\Larmo\Infrastructure\Adapter\PhpUniqidGenerator;

class MessageTest extends PHPUnit_Framework_TestCase
{

    private $message;
    private $author;
    private $timestamp;

    public function setup()
    {
        $this->timestamp = 1434453297;
        $this->author = new Author('Test author');
        $this->message = new Message('irc', $this->timestamp, $this->author, new UniqueId(new PhpUniqidGenerator), 'Body string', array('extra' => 'string'));
    }

    /**
     * @test
     */
    public function messageTypeIsSet()
    {
        $this->assertEquals('irc', $this->message->getType());
    }

    /**
     * @test
     */
    public function messageTimestampIsSet()
    {
        $this->assertEquals($this->timestamp, $this->message->getTimestamp());

        $currentTime = time();
        $this->message->setTimestamp($currentTime);

        $this->assertEquals($currentTime, $this->message->getTimestamp());
    }

    /**
     * @test
     */
    public function messageHasAuthorData()
    {
        $this->assertTrue($this->message->getAuthor() instanceof \FP\Larmo\Domain\ValueObject\Author);
        $this->assertEquals('Test author', $this->message->getAuthor()->getFullName());
    }

    /**
     * @test
     */
    public function messageHasId()
    {
        $this->assertNotEmpty($this->message->getMessageId());
    }

    /**
     * @test
     */
    public function messageHasBody()
    {
        $this->assertEquals('Body string', $this->message->getBody());
    }

    /**
     * @test
     */
    public function messageHasExtras()
    {
        $this->assertArraySubset(array('extra' => 'string'), $this->message->getExtras());
    }
}