<?php
namespace Behat\Behat\Context\Fixtures\Providers;

/**
 * Class AgentPacket
 * @package Behat\Behat\Context\Fixtures\Providers
 *
 * Agent packet fixture provider
 */
class AgentPacket
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
        $this->agentPacket = json_decode(file_get_contents(__DIR__.'/../agentPacket.json'), true);
    }

    /**
     * Sets this packet as a valid one
     *
     * @return $this
     */
    public function wellFormedPacket()
    {
        $this->isValidPacket = true;
        return $this;
    }

    /**
     * Empty this packet and sets it as a wrong structured one
     *
     * Used to test behaviour when comparing against a schema
     *
     * @return $this
     */
    public function wrongStructuredPacket()
    {
        $this->agentPacket = array();
        $this->isValidPacket = false;
        return $this;
    }

    /**
     * Force specific wrong fields in desired key
     *
     * @param $key
     */
    private function forceWrongFields($key)
    {
        array_walk_recursive($this->agentPacket[$key], function(&$element, $key) {
            foreach ($this->wrongFields as $singleWrongField) {
                if ($key === $singleWrongField[0]) {
                    $element = $singleWrongField[1];
                }
            }
        });
    }

    /**
     * Force specific wrong fields and sets it as a wrong populated packet
     *
     * @param string $key Packet key where modifications will be performed: 'metadata' || 'data'
     * @param array $wrongFields Associative array containing the fields to modify
     *
     * @return $this
     */
    public function wrongPopulatedPacket($key, $wrongFields)
    {
        $this->wrongFields = $wrongFields;

        if (isset($this->agentPacket[$key]) && is_array($this->agentPacket[$key])) {
            $this->forceWrongFields($key);
        }

        $this->isValidPacket = false;
        return $this;
    }

    /**
     * Gets a JSON packet fixture ready to be used in tests
     *
     * @return string
     * @throws \Exception
     */
    public function build()
    {
        if (is_null($this->isValidPacket)) {
            throw new \Exception('Packet validation status has not been explicitly set!');
        }

        return json_encode($this->agentPacket);
    }

}