<?php

use Behat\Behat\Context\BehatContext;
use Behat\Behat\Exception\PendingException;
use PHPUnit_Framework_MockObject_Generator as MockObject;
use \FP\Larmo\Domain\Aggregate\Packet;
use \FP\Larmo\Domain\Entity\Metadata;
use \FP\Larmo\Domain\Entity\Message;
use \FP\Larmo\Domain\ValueObject\Author;
use \FP\Larmo\Domain\Service\MessageCollection;
use \FP\Larmo\Infrastructure\Adapter\PhpUniqidGenerator;

class CreatePacketContext extends BehatContext
{

    /**
     * @var Metadata entity
     */
    private $metadata;

    /**
     * @var MessageCollection Factory
     */
    private $messages;

    /**
     * @var Packet Aggregate
     */
    private $packet;

    /**
     * @var string Plugin identifier
     */
    private $pluginID;

    /**
     * @Given /^I create a packet$/
     */
    public function iCreateAPacket()
    {
        return array(
            new Behat\Behat\Context\Step\Given('a metadata entity created from decoded string'),
            new Behat\Behat\Context\Step\Given('a message entity created from decoded string'),
            new Behat\Behat\Context\Step\Given('a packet aggregate is created from metadata and message entities')
        );
    }

    /**
     * @Given /^a metadata entity created from decoded string$/
     */
    public function aMetadataEntityCreatedFromDecodedString()
    {
        $mockObject = new MockObject;
        $authInterface = $mockObject->getMock('\FP\Larmo\Domain\Service\AuthInfoInterface');
        $head = $this->getMainContext()->decodedString['head'];
        $this->metadata = new Metadata($authInterface, $head['time'], $head['auth'], $head['source']);
    }

    /**
     * @Given /^a message entity created from decoded string$/
     */
    public function aMessageEntityCreatedFromDecodedString()
    {
        $messageCollectionFromDecodedString = $this->getMainContext()->decodedString['messages'];
        $uniqueIDGenerator = new PhpUniqidGenerator;
        $this->messages =  new MessageCollection;

        foreach($messageCollectionFromDecodedString as $singleMessage) {
            $author = new Author('', '', $singleMessage['author']['email']);
            $this->messages->append(new Message(
                $singleMessage['type'],
                $singleMessage['time'],
                $author,
                $uniqueIDGenerator,
                $singleMessage['body'])
            );
        }
    }

    /**
     * @Given /^a packet aggregate is created from metadata and message entities$/
     */
    public function aPacketAggregateIsCreatedFromMetadataAndMessageEntities()
    {
        $this->packet = new Packet($this->messages, $this->metadata);
    }

    /**
     * @When /^auth info fails to validate$/
     */
    public function authInfoFailsToValidate()
    {
        try
        {
            // @NOTE: Now this is the only way to validate authInfo in Metadata entity. 
            //        Should not be validated when we inject it?
            $this->packet->getMetadata()->setAuthInfo('NOT_VALID_AUTH_INFO');
        } 
        catch (Exception $exception)
        {
            if (!$exception instanceof \InvalidArgumentException) {
                throw new Exception('The thrown exception does not match with the expected one');
            }
        }
    }

    /**
     * @Given /^a plugin identifier provided by metadata source field$/
     */
    public function aPluginIdentifierProvidedByMetadataSourceField()
    {
        $this->pluginID = $this->packet->getMetadata()->getSource();
    }

    /**
     * @When /^that plugin is not registered in system$/
     */
    public function thatPluginIsNotRegisteredInSystem()
    {
        throw new PendingException();
    }

    /**
     * @Then /^I drop the packet$/
     */
    public function iDropThePacket()
    {
        throw new PendingException();
    }

}