<?php

namespace FP\Larmo\Plugin\Bitbucket;

use FP\Larmo\Domain\Service\PluginManifestInterface;

class PluginManifest implements PluginManifestInterface
{
    private $ident = 'bitbucket';
    private $name = 'BitBucket';

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