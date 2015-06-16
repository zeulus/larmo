<?php

use FP\Larmo\Domain\Entity\Message;
use FP\Larmo\Domain\Service\MessageCollection;
use FP\Larmo\Domain\Service\Packet;
use FP\Larmo\Domain\ValueObject\Author;
use FP\Larmo\Infrastructure\Adapter\PhpUniqidGenerator;

class PacketsTest extends PHPUnit_Framework_TestCase {

    /**
     * @test
     */
    public function packageCanHaveMultipleMessages() {

        $messages = new MessageCollection();
        $messages->append(
            new Message('irc.new_message', time(), new Author('', 'oper'), new PhpUniqidGenerator())
        );
        $messages->append(
            new Message('irc.new_message', time()+1, new Author('', 'oper'), new PhpUniqidGenerator())
        );
        $packet = new Packet($messages);

        $this->assertEquals($packet->getMessages()->count(), count($messages));
        $this->assertEquals(2, $packet->getMessages()->count());
    }

}