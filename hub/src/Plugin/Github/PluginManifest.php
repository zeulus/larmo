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

    public function getEventSubscriber()
    {
        return null;
    }

    public function getDisplayName()
    {
        return $this->name;
    }
}