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
    public function aPacketComingFromAnAgentWithTheFollowingFieldWrong($key, TableNode $table)
    {
        $this->agentPacket = self::$agentPacketFixtureProvider
            ->wrongPopulatedPacket($key, $table->getRows())
            ->build();
    }

}