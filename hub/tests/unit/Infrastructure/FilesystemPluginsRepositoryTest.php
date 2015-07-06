<?php

class FilesystemPluginsRepositoryTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function canRetrievePlugins()
    {
        $this->markTestSkipped('FilesystemPluginsRepository - needs add a dependency injection for DirectoryIterator');
    }
}