<?php

use \Behat\Behat\Context\BehatContext;

/**
 * Features context.
 */
class FeatureContext extends BehatContext
{

    /**
     * Initializes context.
     * Every scenario gets its own context object.
     *
     * @param array $parameters context parameters (set them up through behat.yml)
     */
    public function __construct(array $parameters)
    {
        $this->useContext('AgentPacket', new AgentPacketContext);
        $this->useContext('DomainPacket', new DomainPacketContext);
        $this->useContext('Plugin', new PluginContext);
    }

}
