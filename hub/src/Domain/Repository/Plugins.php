<?php

namespace FP\Larmo\Infrastructure\Repository;

use FP\Larmo\Domain\Service\PluginsCollection;
use FP\Larmo\Infrastructure\Service\PluginsAdapterInterface;

class PluginsRepository
{

    /**
     * @var PluginsAdapterInterface
     */
    private $adapter;

    public function __construct(PluginsAdapterInterface $adapter)
    {
        $this->adapter = $adapter;
    }

    public function registerPlugins(PluginsCollection $collection)
    {
        $this->adapter->loadPlugins($collection);
    }
}