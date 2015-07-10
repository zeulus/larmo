<?php

use Behat\Behat\Context\BehatContext;

class DomainPacketContext extends BehatContext
{

    /**
     * @var array Associative array created from agent packet fixture JSON string
     */
    private $decodedString;

    /**
     * @var FP\Larmo\Domain\Entity\Metadata
     */
    private $metadata;

    /**
     * @var FP\Larmo\Domain\Service\MessageCollection
     */
    private $messageCollection;

    /**
     * @var FP\Larmo\Domain\Aggregate\Packet
     */
    private $packet;

    /**
     * @Then /^The Agent Packet is decoded into an array$/
     */
    public function theAgentPacketIsDecodedIntoAnArray()
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
     * @Then /^The Domain Packet Aggregate is created$/
     */
    public function theDomainPacketAggregateIsCreated()
    {
        if (is_null($this->decodedString)) {
            throw new Exception('There is no agent packet to build a domain packet');
        }

        /** @var callable $metadataEntityContainer */
        $metadataEntityContainer = FeatureContext::$container['metadata.entity'];
        $this->metadata = $metadataEntityContainer(
            $this->decodedString['metadata'],
            FeatureContext::$container['authinfo']
        );

        /** @var callable $messageCollectionContainer */
        $messageCollectionContainer = FeatureContext::$container['message_collection.service'];
        $this->messageCollection = $messageCollectionContainer($this->decodedString['data']);

        /** @var callable $packetAggregate */
        $packetAggregate = FeatureContext::$container['packet.aggregate'];
        $this->packet = $packetAggregate($this->messageCollection, $this->metadata);
    }

}