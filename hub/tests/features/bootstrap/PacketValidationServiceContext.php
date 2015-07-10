<?php

use Behat\Behat\Context\BehatContext;

class PacketValidationServiceContext extends BehatContext
{

    private $isValidAgentPacket;

    /**
     * @var \FP\Larmo\Application\PacketValidationService
     */
    public static $packetValidationServiceInstance;

    /**
     * @beforeScenario
     */
    public static function preparePluginContext()
    {
        self::$packetValidationServiceInstance = FeatureContext::$container['packet_validation.service'];
    }

    /**
     * @When /^The Agent Packet is validated$/
     */
    public function theAgentPacketIsValidated()
    {
        if (is_null($this->getMainContext()->getSubcontext('AgentPacket')->agentPacket)) {
            throw new Exception('There is no agent packet to be verified');
        }

        $decodedPacketString = json_decode($this->getMainContext()->getSubcontext('AgentPacket')->agentPacket);
        $schema = __DIR__ . '/Fixtures/agentPacketSchema.json';

        $this->isValidAgentPacket = self::$packetValidationServiceInstance
            ->setSchemaFromFile($schema)
            ->setPacket($decodedPacketString)
            ->isValid();
    }

    /**
     * @Then /^It should have been accepted by the Packet Validation Service$/
     */
    public function itShouldHaveBeenAcceptedByThePacketValidationService()
    {
        if (!$this->isValidAgentPacket) {
            throw new Exception('Packet Validation Service should ACCEPT the Agent Packet at this step.');
        }
    }

    /**
     * @Then /^It should have been rejected by the Packet Validation Service$/
     */
    public function itShouldHaveBeenRejectedByThePacketValidationService()
    {
        if ($this->isValidAgentPacket) {
            throw new Exception('Packet Validation Service should REJECT the Agent Packet at this step.');
        }
    }

    /**
     * @Then /^The rejection reason must be "([^"]*)"$/
     */
    public function theRejectionReasonMustBe($rejectionReason)
    {
        $foundReason = false;

        foreach (self::$packetValidationServiceInstance->getErrors() as $singleError) {
            if ($singleError['message'] === $rejectionReason) {
                $foundReason = true;
            }
        }

        if (!$foundReason) {
            throw new Exception('Expected rejection reason not found: '.$rejectionReason);
        }
    }

}