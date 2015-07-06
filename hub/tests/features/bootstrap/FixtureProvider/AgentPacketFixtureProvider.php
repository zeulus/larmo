<?php
namespace Behat\Behat\Context\FixtureProvider;

/**
 * Class AgentPacketFixtureProvider
 * @package Behat\Behat\Context\FixtureProvider
 *
 * Provider for Agent Packets
 */
class AgentPacketFixtureProvider
{

    /**
     * @var bool Flag to determine packet health
     */
    private $isValidPacket;

    /**
     * @var array Decoded agent packet
     */
    private $agentPacket = array();

    /**
     * @var array Wrong fields used to force wrong packets
     */
    private $wrongFields = array();

    public function __construct()
    {
        $this->agentPacket = json_decode(file_get_contents(__DIR__.'/agentPacketFixture.json'), true);
    }

    public function wellFormedPacket()
    {
        $this->isValidPacket = true;
        return $this;
    }

    public function wrongStructuredPacket()
    {
        $this->agentPacket = array();
        $this->isValidPacket = false;
        return $this;
    }

    private function forceWrongFields($parentProperty)
    {
        array_walk_recursive($this->agentPacket[$parentProperty], function(&$element, $key) {
            foreach ($this->wrongFields as $singleWrongField) {
                if ($key === $singleWrongField[0]) {
                    $element = $singleWrongField[1];
                }
            }
        });
    }

    public function wrongFormedPacket($parentProperty, $wrongFields)
    {
        $this->wrongFields = $wrongFields;

        if (isset($this->agentPacket[$parentProperty]) && is_array($this->agentPacket[$parentProperty])) {
            $this->forceWrongFields($parentProperty);
        }

        $this->isValidPacket = false;
        return $this;
    }

    public function getSchema()
    {
        return $this->agentPacketSchema;
    }

    public function build()
    {
        if (is_null($this->isValidPacket)) {
            throw new \Exception('Packet health has not been explicitly set!');
        }

        return json_encode($this->agentPacket);
    }

}