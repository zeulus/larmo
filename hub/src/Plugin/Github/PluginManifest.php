<?php

namespace FP\Larmo\Plugin\Github;

use FP\Larmo\Application\PluginService;
use FP\Larmo\Domain\Service\PluginManifestInterface;

class PluginManifest implements PluginManifestInterface
{
    private $ident = 'github';
    private $name = 'GitHub';

    public function getIdentifier()
    {
        return $this->ident;
    }

    public function getCapabilities()
    {
        return PluginService::IS_INPUT;
    }

    public function registerValidators()
    {
        // TODO: Implement registerValidators() method.
    }

    public function getDisplayName()
    {
        return $this->name;
    }
}