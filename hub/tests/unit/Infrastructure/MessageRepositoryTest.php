<?php

use FP\Larmo\Domain\Service\FiltersCollection;
use FP\Larmo\Domain\Service\MessageCollection;
use FP\Larmo\Infrastructure\Repository\MessageRepository;

class MessageRepositoryTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var \FP\Larmo\Domain\Service\MessageCollection
     */
    private $messages;
    private $storageProvider;
    private $filters;

    public function setup()
    {
        $this->messages = new MessageCollection();

        $this->filters = new FiltersCollection();

        $this->storageProvider = $this->getMockBuilder('\FP\Larmo\Infrastructure\Service\MessageStorageProvider')
            ->setMethods(array('store', 'setFilters', 'retrieve'))->getMock();
    }

    /**
     * @test
     */
    public function messageRepositoryRequiresStorageProvider()
    {
        $this->setExpectedException('PHPUnit_Framework_Error');
        $repo = new MessageRepository(new \stdClass());
    }

    /**
     * @test
     */
    public function messageRepositoryRequiresDataToBeStored()
    {
        $repo = new MessageRepository($this->storageProvider);
        $this->setExpectedException('PHPUnit_Framework_Error');
        $repo->store();
    }

    /**
     * @test
     */
    public function messageRepositoryStoresData()
    {
        $repo = new MessageRepository($this->storageProvider);
        $message = $this->getMockBuilder('\FP\Larmo\Domain\Entity\Message')->disableOriginalConstructor()->getMock();
        $this->messages[] = $message;
        $this->messages[] = $message;

        $this->assertEquals(2, count($this->messages));

        $storedData = array();

        $this->storageProvider->expects($this->once())
            ->method('store')
            ->will($this->returnCallback(
                function (MessageCollection $c) use (&$storedData) {
                    foreach($c as $message) {
                        $storedData[] = $message;
                    }
                }
            ));

        $repo->store($this->messages);

        $this->assertEquals(2, count($storedData));

        return $storedData;
    }

    /**
     * @test
     * @depends messageRepositoryStoresData
     */
    public function repositoryRetrievesMessageCollection($storedData)
    {
        $repo = new MessageRepository($this->storageProvider);

        $this->storageProvider->expects($this->once())
            ->method('retrieve')
            ->will($this->returnCallback(
                function (MessageCollection $c) use ($storedData) {
                    foreach ($storedData as $message) {
                        $c->append($message);
                    }
                }
            ));


        $messages = $repo->retrieve($this->filters);

        $this->assertInstanceOf('FP\Larmo\Domain\Service\MessageCollection', $messages);
        $this->assertEquals(2, count($messages));
    }

}