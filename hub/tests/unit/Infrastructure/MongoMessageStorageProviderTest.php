<?php

use FP\Larmo\Domain\Service\MessageCollection;
use FP\Larmo\Infrastructure\Adapter\MongoMessageStorageProvider;

class MongoMessageStorageProviderTest extends PHPUnit_Framework_TestCase
{
    private $mongo;

    public function setup()
    {
        $app = array();
        require_once __DIR__ . '/../../../config/mongo_config.php';

        try {
            $this->mongo = new MongoMessageStorageProvider($app['mongo_db']);
        } catch(\MongoConnectionException $e) {

        }
    }

    /**
     * @test
     */
    public function messagesAreStoreInDatabase()
    {
        $messages = new MessageCollection();
        $this->assertEquals(true, $this->mongo->store($messages));
    }

    /**
     *
     */
    public function checkThatRetrieveWorks()
    {
        $messages = new MessageCollection();
        $this->assertEquals($messages, $this->mongo->retrieve($messages));
    }


}
