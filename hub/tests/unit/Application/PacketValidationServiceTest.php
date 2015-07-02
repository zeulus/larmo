<?php

use FP\Larmo\Application\Adapter\VendorJsonSchemaValidation;
use FP\Larmo\Application\PacketValidationService;
use FP\Larmo\Infrastructure\Adapter\IniFileAuthInfoProvider;
use FP\Larmo\Infrastructure\Adapter\FilesystemPluginsAdapter;
use FP\Larmo\Domain\Service\PluginsCollection;
use FP\Larmo\Infrastructure\Repository\PluginsRepository;
use FP\Larmo\Application\PluginService;
use FP\Larmo\Domain\Aggregate\Packet;
use FP\Larmo\Domain\Entity\Metadata;
use FP\Larmo\Domain\Service\MessageCollection;

class PacketValidationServiceTest extends PHPUnit_Framework_TestCase
{
    private $packetValidation;
    private $schema;

    public function setup()
    {
        $path = __DIR__ . '/../../../';
        $this->schema = __DIR__ . '/../../../config/packet.scheme.json';

        $jsonValidator = new VendorJsonSchemaValidation();
        $authinfo = new IniFileAuthInfoProvider($path . 'config/authinfo.ini');

        $pluginAdapter = new FilesystemPluginsAdapter($path . 'src/Plugin');
        $pluginCollection = new PluginsCollection;
        $pluginRepository = new PluginsRepository($pluginAdapter);
        $pluginRepository->registerPlugins($pluginCollection);
        $pluginsService = new PluginService($pluginCollection);

        $this->packetValidation = new PacketValidationService($jsonValidator, $authinfo, $pluginsService);
    }

    /**
     * @test
     */
    public function setSchemaWorks()
    {
        $this->assertInstanceOf(PacketValidationService::class, $this->packetValidation->setSchemaFromFile($this->schema));
    }

    /**
     * @test
     */
    public function setPacketWorks()
    {
        $authInfoValidator = $this->getMockBuilder('\FP\Larmo\Domain\Service\AuthInfoInterface')->setMethods(array('validate'))->getMock();
        $metadata = new Metadata($authInfoValidator, time(), 'AUTH_INFO', 'SOURCE');
        $messages = new MessageCollection();
        $packet = new Packet($messages, $metadata);

        $this->assertInstanceOf(PacketValidationService::class, $this->packetValidation->setPacket($packet));
    }

    public function validatePacketShouldWorks()
    {
        $this->assertTrue($this->packetValidation->isValid());
    }

    public function errorsAreArray()
    {
        $this->assertTrue(is_array($this->packetValidation->getErrors()));
    }
}
