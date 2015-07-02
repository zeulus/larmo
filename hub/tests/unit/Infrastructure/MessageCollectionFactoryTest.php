<?php

use FP\Larmo\Domain\Service\MessageCollection;
use FP\Larmo\Domain\ValueObject\UniqueId;
use FP\Larmo\Infrastructure\Adapter\PhpUniqidGenerator;
use FP\Larmo\Infrastructure\Factory\MessageCollection as MessageCollectionFactory;

class MessageCollectionFactoryTest extends PHPUnit_Framework_TestCase
{
    private $messageCollectionFactory;

    public function setup()
    {
        $generator = new PhpUniqidGenerator();
        $uniqueId = new UniqueId($generator);
        $this->messageCollectionFactory = new MessageCollectionFactory($uniqueId);
    }

    /**
     * @test
     */
    public function createMessageFromArrayWorks()
    {
        $messages[] = array('type' => 'github.push', 'timestamp' => time());
        $messageCollection = $this->messageCollectionFactory->fromArray($messages);
        $this->assertInstanceOf(MessageCollection::class, $messageCollection);
    }
}
