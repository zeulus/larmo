<?php

use FP\Larmo\Domain\Service\PluginsCollection;
use FP\Larmo\Infrastructure\Repository\PluginsRepository;

class PluginsRepositoryTest extends PHPUnit_Framework_TestCase
{

    /**
     * @test
     */
    public function pluginsRepositoryRequiresPluginsAdapterInterface()
    {
        $this->setExpectedException('PHPUnit_Framework_Error');
        $repository = new PluginsRepository();
        $repository = new PluginsRepository($this);
    }

    /**
     * @test
     */
    public function pluginsRepositoryWillRegisterPluginsToCollection()
    {
        $fakePlugin = $this->getMockBuilder('FP\Larmo\Domain\Service\PluginManifestInterface')->getMock();

        $adapter = $this->getMockBuilder('FP\Larmo\Infrastructure\Service\PluginsAdapterInterface', array('loadPlugins'))->getMock();
        $adapter->expects($this->once())
            ->method('loadPlugins')
            ->will($this->returnCallback(function (PluginsCollection $c) use ($fakePlugin) {$c->append($fakePlugin); }));

        $repository = new PluginsRepository($adapter);
        $collection = new PluginsCollection();
        $repository->registerPlugins($collection);

        $this->assertEquals(1, count($collection));
    }
}