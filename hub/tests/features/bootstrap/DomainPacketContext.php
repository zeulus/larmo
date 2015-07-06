<?php

use Behat\Behat\Context\BehatContext;
use PHPUnit_Framework_MockObject_Generator as MockObject;
use FP\Larmo\Domain\Aggregate\Packet;
use FP\Larmo\Domain\Entity\Metadata;
use FP\Larmo\Domain\Entity\Message;
use FP\Larmo\Domain\ValueObject\Author;
use FP\Larmo\Domain\ValueObject\UniqueId;
use FP\Larmo\Domain\Service\MessageCollection;
use FP\Larmo\Infrastructure\Adapter\PhpUniqidGenerator;

class DomainPacketContext extends BehatContext
{

    private $decodedString;
    private $metadata;
    private $messages;
    private $packet;

    /**
     * @When /^I decode a packet coming from an agent into an array$/
     */
    public function iDecodeAPacketComingFromAnAgentIntoAnArray()
    {
        if (is_null($this->getMainContext()->getSubcontext('AgentPacket')->agentPacket)) {
            throw new Exception('There is no agent packet to decode');
        }

        $this->decodedString = json_decode($this->getMainContext()->getSubcontext('AgentPacket')->agentPacket, true);
        if (!json_last_error() == JSON_ERROR_NONE) {
            throw new Exception('Json last error: '.json_last_error_msg());
        }
    }

    /**
     * @Then /^The system can create a packet in the domain$/
     */
    public function theSystemCanCreateAPacketInTheDomain()
    {
        if (is_null($this->decodedString)) {
            throw new Exception('There is no agent packet to build a domain packet');
        }

        $mockObject = new MockObject;
        $authInterface = $mockObject->getMock('\FP\Larmo\Domain\Service\AuthInfoInterface');
        $metadata = $this->decodedString['metadata'];
        $this->metadata = new Metadata($authInterface, $metadata['timestamp'], $metadata['authinfo'], $metadata['source']);

        $messageCollectionFromDecodedString = $this->decodedString['data'];
        $uniqueIDGenerator = new PhpUniqidGenerator;
        $uniqueIDValueObject = new UniqueId($uniqueIDGenerator);
        $this->messages =  new MessageCollection;

        foreach($messageCollectionFromDecodedString as $singleMessage) {
            $author = new Author('', '', $singleMessage['author']['email']);
            $this->messages->append(new Message(
                    $singleMessage['type'],
                    $singleMessage['timestamp'],
                    $author,
                    $uniqueIDValueObject,
                    $singleMessage['message'])
            );
        }

        $this->packet = new Packet($this->messages, $this->metadata);
    }

}