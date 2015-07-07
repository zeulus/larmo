<?php

use Behat\Behat\Context\BehatContext;

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

        $metadataEntityContainer = FeatureContext::$app['metadata.entity'];
        $this->metadata = $metadataEntityContainer(
            $this->decodedString['metadata'],
            FeatureContext::$app['authinfo']
        );

        $messageEntityContainer = FeatureContext::$app['message.entity'];
        $this->messages = $messageEntityContainer($this->decodedString['data']);

        $packetAggregate = FeatureContext::$app['packet.aggregate'];
        $this->packet = $packetAggregate($this->messages, $this->metadata);
    }

}