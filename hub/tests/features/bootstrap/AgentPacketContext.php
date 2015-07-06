<?php

use Behat\Behat\Context\BehatContext;
use Behat\Behat\Context\FixtureProvider\AgentPacketFixtureProvider;
use Behat\Gherkin\Node\TableNode;

class AgentPacketContext extends BehatContext
{

    public $agentPacket;
    public $agentPacketSchema;

    public static $agentPacketFixtureProvider;

    /**
     * @beforeScenario
     */
    public static function prepareAgentPacketFixtureProvider()
    {
        self::$agentPacketFixtureProvider = new AgentPacketFixtureProvider;
    }

    /**
     * @Given /^A packet coming from an agent with invalid structure$/
     */
    public function aPacketComingFromAnAgentWithInvalidStructure()
    {
        $this->agentPacket = self::$agentPacketFixtureProvider
            ->wrongStructuredPacket()
            ->build();
    }

    /**
     * @Given /^A well formed packet coming from an agent$/
     */
    public function aWellFormedPacketComingFromAnAgent()
    {
        $this->agentPacket = self::$agentPacketFixtureProvider
            ->wellFormedPacket()
            ->build();
    }

    /**
     * @Given /^A packet coming from an agent with the following "([^"]*)" wrong:$/
     */
    public function aPacketComingFromAnAgentWithTheFollowingFieldWrong($parentProperty, TableNode $table)
    {
        $this->agentPacket = self::$agentPacketFixtureProvider
            ->wrongFormedPacket($parentProperty, $table->getRows())
            ->build();
    }

}