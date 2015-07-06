<?php

// use FP\Larmo\Domain\Service\PluginsCollection;
use FP\Larmo\Infrastructure\Repository\FilesystemPlugins as FilesystemPluginsRepository;

class FilesystemPluginsRepositoryTest extends PHPUnit_Framework_TestCase
{

    /**
     * @test
     */
    public function pluginsRepositoryRequiresPluginsAdapterInterface()
    {
        $this->setExpectedException('PHPUnit_Framework_Error');
        $repository = new FilesystemPluginsRepository('');
    }

    /**
     * @test
     */
    public function pluginsRepositoryWillRegisterPluginsToCollection()
    {
        $this->markTestSkipped('FilesystemPluginsRepository - needs add a dependency injection for DirectoryIterator');

        /*
        $fakePlugin = $this->getMockBuilder('FP\Larmo\Domain\Service\PluginManifestInterface')->getMock();

        $adapter = $this->getMockBuilder('FP\Larmo\Infrastructure\Service\PluginsAdapterInterface',
            array('loadPlugins'))->getMock();
        $adapter->expects($this->once())
            ->method('loadPlugins')
            ->will($this->returnCallback(function (PluginsCollection $c) use ($fakePlugin) {
                $c->append($fakePlugin);
            }));

        $repository = new PluginsRepository($adapter);
        $collection = new PluginsCollection();
        $repository->registerPlugins($collection);

        $this->assertEquals(1, count($collection));
        */
    }
}