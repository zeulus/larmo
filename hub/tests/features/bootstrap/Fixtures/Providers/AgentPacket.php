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
    public function malformedPacket()
    {
        $this->agentPacket = array();
        $this->isValidPacket = false;
        return $this;
    }

    /**
     * Override a list of fields in the Agent Packet array
     *
     * The first dimension in Agent Packet array contains the following keys
     *  [
     *   'metadata' => Array (timestamp, source info, authinfo),
     *   'data' => Array (collection of messages)
     *  ]
     *
     * On every iteration in the desired dimension:
     *  - We loop through the array containing the fields to override:
     *    - If there is a match between the current Agent Packet key and the current key we want to override,
     *      the actual value for Agent Packet is overridden.
     *
     * To achieve this goal, array_walk_recursive() function is used
     * @link http://php.net/manual/en/function.array-walk-recursive.php
     *
     * @param string $key First dimension of Agent Packet array
     */
    private function overrideFields($key)
    {
        // Important: in the callback, because we need to work with the actual values of the Agent Packet array
        // we must specify the first parameter as a reference.
        array_walk_recursive($this->agentPacket[$key], function(&$agentPacketValue, $agentPacketKey) {
            foreach ($this->wrongFields as $singleWrongField) {
                if ($agentPacketKey === $singleWrongField[0]) {
                    // Note that what we modify here is the actual value of Agent Packet array.
                    $agentPacketValue = $singleWrongField[1];
                }
            }
        });
    }

    /**
     * Override fields and sets it as an invalid agent packet
     *
     * @param string $key First dimension of Agent Packet array
     * @param array $wrongFields Associative array containing the fields to modify
     *
     * @return $this
     */
    public function packetWithWrongData($key, $wrongFields)
    {
        $this->wrongFields = $wrongFields;

        if (isset($this->agentPacket[$key]) && is_array($this->agentPacket[$key])) {
            $this->overrideFields($key);
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