<?php

use Behat\Behat\Context\BehatContext;
use Behat\Behat\Exception\PendingException;
use PHPUnit_Framework_MockObject_Generator as MockObject;
use \FP\Larmo\Domain\Entity\Metadata;

class CreatePacketContext extends BehatContext
{

    /**
     * @var Metadata entity
     */
    private $metadata;
    
    /**
     * @Given /^a packet metadata created from decoded string$/
     */
    public function aPacketMetadataCreatedFromDecodedString()
    {
        $mockObject = new MockObject;
        $authInterface = $mockObject->getMock('\FP\Larmo\Domain\Service\AuthInfoInterface');
        $head = $this->getMainContext()->decodedString['head'];
        $this->metadata = new Metadata($authInterface, time(), $head['auth'], $head['source']);
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
            $this->metadata->setAuthInfo('NOT_VALID_AUTH_INFO');
        } 
        catch (Exception $exception)
        {
            if (!$exception instanceof \InvalidArgumentException) {
                throw new Exception('The thrown exception does not match with the expected one');
            }
        }
    }

    /**
     * @Given /^a plugin identifier provided by "([^"]*)" metadata field$/
     */
    public function aPluginIdentifierProvidedByMetadataField($metadataField)
    {
        throw new PendingException();
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