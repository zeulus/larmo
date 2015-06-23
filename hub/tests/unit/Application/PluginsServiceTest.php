<?php

use FP\Larmo\Application\PluginService;
use FP\Larmo\Domain\Service\PluginsCollection;

class PluginsServiceTest extends PHPUnit_Framework_TestCase
{

    private $pluginDetails = ['skype' => 'Microsoft Skype', 'github' => 'GitHub'];
    private $plugins;

    public function setup()
    {
        $this->plugins = new PluginsCollection();

        foreach ($this->pluginDetails as $ident => $name) {
            $pluginA = $this->getMockBuilder('FP\Larmo\Domain\Service\PluginManifestInterface')->getMock();
            $pluginA->method('getIdentifier')
                ->willReturn($ident);
            $pluginA->method('getDisplayName')
                ->willReturn($name);

            $this->plugins->append($pluginA);
        }

        $this->assertEquals(count($this->pluginDetails), count($this->plugins));
    }

    /**
     * @test
     */
    public function createPluginsServiceFromPluginsCollection()
    {
        $pluginService = new PluginService($this->plugins);
        $this->assertInstanceOf('FP\Larmo\Application\PluginService', $pluginService);

        $registeredPlugins = $pluginService->getRegisteredPlugins();
        $this->assertEquals(count($registeredPlugins), count($this->plugins));

        return $pluginService;
    }

    /**
     * @test
     * @depends createPluginsServiceFromPluginsCollection
     */
    public function checkIfPluginExists(PluginService $pluginService)
    {
        $this->assertTrue($pluginService->checkPluginIsRegistered('skype'));
        $this->assertFalse($pluginService->checkPluginIsRegistered('unknown'));
    }

    /**
     * @test
     * @depends createPluginsServiceFromPluginsCollection
     */
    public function getPluginDisplayNameReturnsActualValue(PluginService $pluginService)
    {
        $this->assertEquals($pluginService->getPluginDisplayName('skype'), $this->pluginDetails['skype']);
    }
}