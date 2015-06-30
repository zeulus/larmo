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
        require __DIR__ . '/../../../config/mongo.php';

        $this->mongo = new MongoMessageStorageProvider($app['config.mongo_db']);
    }

    /**
     * @test
     */
    public function messagesAreStoringInDatabase()
    {
        $collection = new MessageCollection();
        $generator = new PhpUniqidGenerator();
        for ($i = 1; $i <= 5; $i++) {
            $message = new Message('skype.new_message', time() + $i, new Author('User ' + $i), new UniqueId($generator));
            $collection->append($message);
        }

        $this->assertArraySubset(array('ok' => 1), $this->mongo->store($collection));
    }

}
