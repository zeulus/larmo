<?php

namespace FP\Larmo\Plugin\Travis;

use FP\Larmo\Domain\Service\PluginManifestInterface;

class PluginManifest implements PluginManifestInterface
{
    private $ident = 'travis';
    private $name = 'Travis CI';

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