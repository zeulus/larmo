<?php

namespace FP\Larmo\Infrastructure\Service;

use FP\Larmo\Domain\Service\PluginsCollection;

interface PluginsAdapterInterface
{

    /**
     * Loads plugins to provided plugin collection.
     *
     * @param PluginsCollection $plugins
     */
    public function loadPlugins(PluginsCollection $plugins);
}