<?php

use FP\Larmo\Domain\Entity\Message;
use FP\Larmo\Domain\ValueObject\UniqueId;
use FP\Larmo\Infrastructure\Adapter\PhpUniqidGenerator;
use FP\Larmo\Infrastructure\Factory\Message as MessageFactory;

class MessageFactoryTest extends PHPUnit_Framework_TestCase
{
    private $messageFactory;

    public function setup()
    {
        $generator = new PhpUniqidGenerator();
        $uniqueId = new UniqueId($generator);
        $this->messageFactory = new MessageFactory($uniqueId);
    }

    /**
     * @test
     */
    public function createMessageFromArrayWorks()
    {
        $message = $this->messageFactory->fromArray(array('type' => 'github.push', 'timestamp' => time()));
        $this->assertInstanceOf(Message::class, $message);
    }
}
