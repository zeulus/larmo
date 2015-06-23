<?php

namespace FP\Larmo\Domain\Service;


interface PluginManifestInterface
{

    public function getIdentifier();

    public function getDisplayName();

    public function getCapabilities();

    public function registerValidators();

}