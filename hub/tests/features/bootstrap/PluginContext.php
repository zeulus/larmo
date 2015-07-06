<?php

use Behat\Behat\Context\BehatContext;
use FP\Larmo\Application\Adapter\VendorJsonSchemaValidation;
use FP\Larmo\Application\PacketValidationService;
use FP\Larmo\Application\PluginService;
use FP\Larmo\Domain\Service\PluginsCollection;
use FP\Larmo\Infrastructure\Repository\FilesystemPlugins;
use FP\Larmo\Infrastructure\Adapter\IniFileAuthInfoProvider;

class PluginContext extends BehatContext
{

    public static $packetValidationServiceInstance;

    /**
     * @beforeScenario
     */
    public static function preparePluginContext()
    {
        $path = __DIR__ . '/../../../';

        $jsonValidator = new VendorJsonSchemaValidation();
        $authinfo = new IniFileAuthInfoProvider($path . 'config/authinfo.ini');

        $pluginsCollection = new PluginsCollection;
        $directoryIterator = new \DirectoryIterator($path . 'src/Plugin');
        $pluginRepository = new FilesystemPlugins($directoryIterator);
        $pluginRepository->retrieve($pluginsCollection);
        $pluginsService = new PluginService($pluginsCollection);

        self::$packetValidationServiceInstance = new PacketValidationService($jsonValidator, $authinfo, $pluginsService);
    }

    /**
     * @When /^The packet is prepared to be verified against a schema$/
     */
    public function thePacketIsPreparedToBeVerifiedAgainstASchema()
    {
        if (is_null($this->getMainContext()->getSubcontext('AgentPacket')->agentPacket)) {
            throw new Exception('There is no agent packet to be verified');
        }

        $decodedPacketString = json_decode($this->getMainContext()->getSubcontext('AgentPacket')->agentPacket);
        $schema = __DIR__ . '/FixtureProvider/agentPacketFixtureSchema.json';

        if (!self::$packetValidationServiceInstance
            ->setSchemaFromFile($schema)
            ->setPacket($decodedPacketString)
        );
    }

    /**
     * @Then /^The plugin service successes to validate$/
     */
    public function thePluginServiceSuccessesToValidate()
    {
        if (!self::$packetValidationServiceInstance->isValid()) {
            throw new Exception('Plugin service should SUCCESS the validation at this step.');
        }
    }

    /**
     * @Then /^The plugin service fails to validate$/
     */
    public function thePluginServiceFailsToValidate()
    {
        if (self::$packetValidationServiceInstance->isValid()) {
            throw new Exception('Plugin service should FAIL the validation at this step.');
        }
    }

    /**
     * @Given /^The packet is rejected with reason "([^"]*)"$/
     */
    public function thePacketIsRejectedWithReason($rejectionReason)
    {
        foreach (self::$packetValidationServiceInstance->getErrors() as $singleError) {
            if ($singleError['message'] === $rejectionReason) {
                break;
            }

            throw new Exception('Expected rejection reason not found: '.$rejectionReason);
        }
    }

}