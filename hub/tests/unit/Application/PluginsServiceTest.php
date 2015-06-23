<?php

use FP\Larmo\Application\PluginService;
use FP\Larmo\Domain\Service\PluginsCollection;

class PluginsServiceTest extends PHPUnit_Framework_TestCase
{

    private $pluginDetails = ['skype' => 'Microsoft Skype', 'github' => 'GitHub'];
    /**
     * @var \FP\Larmo\Domain\Service\PluginsCollection
     */
    private $plugins;

    public function setup()
    {
        $this->plugins = new PluginsCollection();

        foreach ($this->pluginDetails as $ident => $name) {
            $plugin = $this->getMockBuilder('FP\Larmo\Domain\Service\PluginManifestInterface')->getMock();
            $plugin->method('getIdentifier')
              ->willReturn($ident);
            $plugin->method('getDisplayName')
              ->willReturn($name);

            $this->plugins->append($plugin);
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

    /**
     * @test
     */
    public function shouldThrowPluginExceptionWhenDuplicatedIdentifier()
    {
        // add duplicated plugin
        $this->plugins->append(clone $this->plugins[0]);
        $this->assertEquals(3, count($this->plugins));
        // last and first plugin are same plugins
        $this->assertEquals($this->plugins[0]->getIdentifier(), $this->plugins[2]->getIdentifier());

        $this->setExpectedException('FP\Larmo\Domain\Exception\PluginException', 'is already registered');
        $pluginService = new PluginService($this->plugins);
    }
}