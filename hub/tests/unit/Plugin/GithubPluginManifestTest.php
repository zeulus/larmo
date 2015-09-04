<?php

use FP\Larmo\Plugin\Github\PluginManifest;

class GithubPluginManifestTest extends PHPUnit_Framework_TestCase
{
    private $jsonValidator;

    public function setup()
    {
        $this->github = new PluginManifest();
    }

    /**
     * @test
     */
    public function pluginHasCorrectIdentifier()
    {
        $this->assertEquals('github', $this->github->getIdentifier());
    }

    /**
     * @test
     */
    public function pluginHasCorrectDisplayName()
    {
        $this->assertEquals('GitHub', $this->github->getDisplayName());
    }
}
