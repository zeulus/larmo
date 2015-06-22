<?php

use FP\Larmo\Domain\Service\FiltersCollection;
use FP\Larmo\Domain\Service\MessageCollection;
use FP\Larmo\Infrastructure\Repository\MessageRepository;

class MessageRepositoryTest extends PHPUnit_Framework_TestCase
{

    private $messages;
    private $storageProvider;
    private $filters;

    public function setup()
    {
        $this->messages = new MessageCollection();

        $this->filters = new FiltersCollection();

        $this->storageProvider = $this->getMockBuilder(
            '\FP\Larmo\Infrastructure\Service\MessageStorageProvider'
        )->setMethods(array('store', 'setFilters', 'retrieve'))->getMock();
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
    public function repositoryRetrievesMessageCollection()
    {
        $repo = new MessageRepository($this->storageProvider);
        $messages = $repo->retrieve($this->filters);

        $this->assertInstanceOf('FP\Larmo\Domain\Service\MessageCollection', $messages);
    }

}