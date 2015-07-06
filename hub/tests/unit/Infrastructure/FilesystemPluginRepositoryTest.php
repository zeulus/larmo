<?php


use FP\Larmo\Domain\Service\PluginsCollection;
use FP\Larmo\Infrastructure\Adapter\FilesystemPluginsAdapter;

class FilesystemPluginRepositoryTest extends PHPUnit_Framework_TestCase
{

    /**
     * @test
     */
    public function pluginsDirectoryExists()
    {
        $path = __DIR__ . '/../../../src/Plugin';
        $path = realpath($path);

        $this->assertNotEmpty($path, 'Please fix path to plugins directory');

        return $path;
    }

    /**
     * @test
     * @depends pluginsDirectoryExists
     * @param $path
     */
    public function filesystemPluginsAdapterWillLoadPlugins($path)
    {
        $adapter = new FilesystemPluginsAdapter($path);
        $collection = new PluginsCollection();

        $this->assertEquals(0, count($collection));

        $adapter->loadPlugins($collection);

        $this->assertTrue(count($collection) > 0);
    }
}