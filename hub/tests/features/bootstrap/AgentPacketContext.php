<?php

use Behat\Behat\Context\BehatContext;
use Behat\Behat\Context\Fixtures\Providers\AgentPacket as AgentPacketFixtureProvider;
use Behat\Gherkin\Node\TableNode;

class AgentPacketContext extends BehatContext
{

    /**
     * @var string JSON created from AgentPacketFixtureProvider
     */
    public $agentPacket;

    /**
     * @var AgentPacketFixtureProvider
     */
    public static $agentPacketFixtureProvider;

    /**
     * @beforeScenario
     */
    public static function prepareAgentPacketFixtureProvider()
    {
        self::$agentPacketFixtureProvider = new AgentPacketFixtureProvider;
    }

    /**
     * @Given /^A malformed Agent Packet$/
     */
    public function aMalformedAgentPacket()
    {
        $this->agentPacket = self::$agentPacketFixtureProvider
            ->malformedPacket()
            ->build();
    }

    /**
     * @Given /^A valid Agent Packet$/
     */
    public function aValidAgentPacket()
    {
        $this->agentPacket = self::$agentPacketFixtureProvider
            ->wellFormedPacket()
            ->build();
    }

    /**
     * @Given /^An Agent Packet with the following wrong "([^"]*)" fields:$/
     */
    public function anAgentPacketWithTheFollowingWrongFields($key, TableNode $table)
    {
        $this->agentPacket = self::$agentPacketFixtureProvider
            ->packetWithWrongData($key, $table->getRows())
            ->build();
    }

}