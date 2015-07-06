<?php

use Prophecy\Argument;

use FP\Larmo\Domain\Service\MessageCollection;
use FP\Larmo\Infrastructure\Adapter\MongoDbStorage;
use FP\Larmo\Infrastructure\Factory\Message as MessageFactory;
use FP\Larmo\Infrastructure\Repository\MongoDbMessages as MongoDbMessagesRepository;

class MongoDbMessagesRepositoryTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var \FP\Larmo\Infrastructure\Adapter\MongoDbStorage
     */
    private $storage;

    /**
     * @var \FP\Larmo\Infrastructure\Repository\MongoDbMessages
     */
    private $repository;

    protected function setUp()
    {
        $this->storage = $this->getMockBuilder(MongoDbStorage::class)
            ->disableOriginalConstructor()
            ->setMethods(['batchInsert', 'find'])
            ->getMock();

        $this->repository = new MongoDbMessagesRepository($this->storage);
    }

    /**
     * @test
     */
    public function canStoreMessages()
    {
        $messageFactory = new MessageFactory;
        $messages = new MessageCollection;

        $messages[] = $messageFactory->fromArray(['id' => '1']);
        $messages[] = $messageFactory->fromArray(['id' => '2']);

        $this->storage->method('batchInsert')->willReturn(true);
        $this->assertTrue($this->repository->store($messages));
    }

    /**
     * @test
     */
    public function canRetrieveMessages()
    {
        $messages = new MessageCollection();
        $retrieved = [['id' => 1], ['id' => 2]];

        $this->storage->method('find')->will($this->returnValue($retrieved));

        $this->assertInstanceOf(MessageCollection::class, $this->repository->retrieve($messages));
        $this->assertEquals($messages, $this->repository->retrieve($messages));
    }

}