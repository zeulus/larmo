<?php

namespace FP\Larmo\Domain\Repository;

use FP\Larmo\Domain\Service\PluginsCollection;

interface Plugins
{
    /**
     * @param PluginsCollection $plugins
     */
    public function retrieve(PluginsCollection $plugins);
}