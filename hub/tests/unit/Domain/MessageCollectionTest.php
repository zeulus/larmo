<?php

use FP\Larmo\Domain\Entity\Message;
use FP\Larmo\Domain\Service\MessageCollection;
use FP\Larmo\Domain\ValueObject\Author;
use FP\Larmo\Domain\ValueObject\UniqueId;
use FP\Larmo\Infrastructure\Adapter\PhpUniqidGenerator;

class MessageCollectionTest extends PHPUnit_Framework_TestCase
{

    /**
     * @test
     */
    public function canAddMessagesToCollection()
    {

        $collection = new MessageCollection();
        $generator = new PhpUniqidGenerator();
        for ($i = 1; $i <= 5; $i++) {
            $message = new Message('skype.new_message', time() + $i, new Author('User ' + $i), new UniqueId($generator));
            $collection->append($message);
        }

        $this->assertEquals(5, count($collection));
    }
}