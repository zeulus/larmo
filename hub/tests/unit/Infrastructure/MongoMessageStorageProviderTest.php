<?php

use FP\Larmo\Domain\Entity\Message;
use FP\Larmo\Domain\Service\MessageCollection;
use FP\Larmo\Infrastructure\Adapter\MongoMessageStorageProvider;
use FP\Larmo\Domain\ValueObject\Author;
use FP\Larmo\Domain\ValueObject\UniqueId;
use FP\Larmo\Infrastructure\Adapter\PhpUniqidGenerator;

class MongoMessageStorageProviderTest extends PHPUnit_Framework_TestCase
{
    private $mongo;

    public function setup()
    {
        $app = array();
        $config = __DIR__ . '/../../../config/';

        require $config . 'mongo.php';
        if (file_exists($config . 'parameters.php')) {
            require $config . 'parameters.php';
        }

        $this->mongo = new MongoMessageStorageProvider($app['config.mongo_db']);
    }

    private function createNewMessageCollection()
    {
        $collection = new MessageCollection();
        $generator = new PhpUniqidGenerator();
        for ($i = 1; $i <= 5; $i++) {
            $message = new Message('skype.new_message', time() + $i, new Author('User ' . $i), new UniqueId($generator));
            $collection->append($message);
        }

        return $collection;
    }

    /**
     * @test
     */
    public function messagesAreStoringAndRetrievingInDatabase()
    {
        // Adding new data
        $this->assertArraySubset(array('ok' => 1), $this->mongo->store($this->createNewMessageCollection()));

        // Retrieving data from DB
        $collection = new MessageCollection();
        $this->mongo->retrieve($collection);
        $this->assertGreaterThan(0, count($collection)); // Collection should contain more than 0 messages
    }

    /**
     * @test
     */
    public function connectionProblemThrowException()
    {
        $this->setExpectedException('MongoConnectionException');
        new MongoMessageStorageProvider(array('db_name' => 'test', 'db_port' => 9999, 'db_url' => 'test'));
    }

}
