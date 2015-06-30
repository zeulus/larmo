<?php

use FP\Larmo\Domain\Entity\Message;
use FP\Larmo\Domain\Entity\Metadata;
use FP\Larmo\Domain\Service\MessageCollection;
use FP\Larmo\Domain\Aggregate\Packet;
use FP\Larmo\Domain\ValueObject\Author;
use FP\Larmo\Domain\ValueObject\UniqueId;
use FP\Larmo\Infrastructure\Adapter\PhpUniqidGenerator;

class PacketsTest extends PHPUnit_Framework_TestCase
{

    private $messages;
    private $authInfoValidator;
    private $metadata;

    public function setup()
    {
        $this->messages = new MessageCollection();
        $this->messages->append(
            new Message('irc.new_message', time(), new Author('', 'oper'), new UniqueId(new PhpUniqidGenerator()))
        );
        $this->messages->append(
            new Message('irc.new_message', time() + 1, new Author('', 'oper'), new UniqueId(new PhpUniqidGenerator()))
        );

        $this->authInfoValidator = $this->getMockBuilder('\FP\Larmo\Domain\Service\AuthInfoInterface')->setMethods(array('validate'))->getMock();
        $this->metadata = new Metadata($this->authInfoValidator, time(), 'AUTH_INFO', 'SOURCE');
    }

    /**
     * @test
     */
    public function packageCanHaveMetadata()
    {
        $packet = new Packet($this->messages, $this->metadata);
        $metadata = $packet->getMetadata();

        $this->assertEquals($metadata, $this->metadata);
    }

    /**
     * @test
     */
    public function packageCanHaveMultipleMessages()
    {

        $packet = new Packet($this->messages, $this->metadata);

        $this->assertEquals($packet->getMessages()->count(), count($this->messages));
        $this->assertEquals(2, $packet->getMessages()->count());
    }

}