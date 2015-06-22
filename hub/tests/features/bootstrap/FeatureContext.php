<?php

use Behat\Behat\Context\BehatContext;
use Behat\Gherkin\Node\PyStringNode;

/**
 * Features context.
 */
class FeatureContext extends BehatContext
{
    public $string;
    public $decodedString;
    
    /**
     * Initializes context.
     * Every scenario gets its own context object.
     *
     * @param array $parameters context parameters (set them up through behat.yml)
     */
    public function __construct(array $parameters)
    {
        $this->useContext('create_packet', new CreatePacketContext);
    }

    /**
     * @Given /^I have received string:$/
     */
    public function iHaveReceivedString(PyStringNode $string)
    {
        $this->string = $string;
    }

    /**
     * @Given /^it is valid JSON string$/
     */
    public function itIsValidJsonString()
    {
        json_decode($this->string);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception('The provided string is not a valid JSON');			
        }
    }

    /**
     * @Given /^can be decoded to array$/
     */
    public function canBeDecodedToArray()
    {
        $this->decodedString = json_decode($this->string, true);
        if (!is_array($this->decodedString)) {
            throw new Exception('The provided string could not be decoded to an array');
        }
    }

}
