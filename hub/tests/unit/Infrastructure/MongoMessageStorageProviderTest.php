<?php

use FP\Larmo\Domain\Entity\Message;
use FP\Larmo\Domain\Service\MessageCollection;
use FP\Larmo\Infrastructure\Adapter\MongoMessageStorageProvider;
use FP\Larmo\Domain\ValueObject\Author;
use FP\Larmo\Infrastructure\Adapter\PhpUniqidGenerator;

class MongoMessageStorageProviderTest extends PHPUnit_Framework_TestCase
{
    private $mongo;

    public function setup()
    {
        $app = array();
        require __DIR__ . '/../../../config/mongo_config.php';

        $this->mongo = new MongoMessageStorageProvider($app['mongo_db']);
    }

    /**
     * @test
     */
    public function messagesAreStoringInDatabase()
    {
        $collection = new MessageCollection();
        $generator = new PhpUniqidGenerator();
        for ($i = 1; $i <= 5; $i++) {
            $message = new Message('skype.new_message', time() + $i, new Author('User ' + $i), $generator);
            $collection->append($message);
        }

        $this->assertArraySubset(array('ok' => 1), $this->mongo->store($collection));
    }


}
