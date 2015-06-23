<?php

namespace FP\Larmo\Application;


use FP\Larmo\Domain\Service\PluginsCollection;

class PluginService
{

    /**
     * @var \FP\Larmo\Domain\Service\PluginsCollection
     */
    private $plugins;
    private $pluginNames = array();

    public function __construct(PluginsCollection $collection)
    {
        $this->plugins = $collection;

        foreach ($this->plugins as $plugin) {
            $this->pluginNames[$plugin->getIdentifier()]
                = $plugin->getDisplayName();
        }
    }

    public function getRegisteredPlugins()
    {
        return array_keys($this->pluginNames);
    }

    public function checkPluginIsRegistered($id)
    {
        return array_key_exists($id, $this->pluginNames);
    }

    public function getPluginDisplayName($id)
    {
        return $this->checkPluginIsRegistered($id)
            ? $this->pluginNames[$id] : null;
    }
}