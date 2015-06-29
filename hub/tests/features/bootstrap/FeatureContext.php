<?php

use Behat\Behat\Context\BehatContext;
use Behat\Gherkin\Node\PyStringNode;
use fkooman\Json\Json;

/**
 * Features context.
 */
class FeatureContext extends BehatContext
{

    /**
     * @var string String retrieved from PyStringNode
     */
    public $string;

    /**
     * @var array Decoded string result from JSON decoding
     */
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
     * @Given /^it can be decoded to an array$/
     */
    public function itCanBeDecodedToAnArray()
    {
        try {
            $this->decodedString = Json::decode($this->string);
        } catch (InvalidArgumentException $exception) {
            throw new Exception('Provided string could not be decoded: '.$exception->getMessage());
        }
    }

}
