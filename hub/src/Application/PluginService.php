<?php

namespace FP\Larmo\Application;

use FP\Larmo\Domain\Exception\PluginException;
use FP\Larmo\Domain\Service\PluginsCollection;

/**
 * Class PluginService
 *
 * IS_INPUT and IS_OUTPUT constants are used to have basic segregation of plugins.
 * It is very likely that these constants will be (re)moved in future.
 *
 * @package FP\Larmo\Application
 */
final class PluginService
{
    const IS_INPUT = 1;
    const IS_OUTPUT = 2;

    /**
     * @var \FP\Larmo\Domain\Service\PluginsCollection
     */
    private $plugins;
    private $pluginNames = array();

    public function __construct(PluginsCollection $collection)
    {
        $this->plugins = $collection;

        foreach ($this->plugins as $plugin) {
            $ident = $plugin->getIdentifier();
            if ($this->checkPluginIsRegistered($ident)) {
                throw new PluginException(sprintf('Plugin "%s" is already registered!', $ident));
            }
            $this->pluginNames[$ident] = $plugin->getDisplayName();
        }
    }

    /**
     * Returns identifiers for registered plugins
     *
     * @return array
     */
    public function getRegisteredPlugins()
    {
        return array_keys($this->pluginNames);
    }

    /**
     * Checks whether the plugin is registered
     *
     * @param string $id
     * @return bool
     */
    public function checkPluginIsRegistered($id)
    {
        return array_key_exists($id, $this->pluginNames);
    }

    /**
     * Returns plugin's display name or null if not found
     *
     * @param string $id
     * @return string|null
     */
    public function getPluginDisplayName($id)
    {
        return $this->checkPluginIsRegistered($id)
            ? $this->pluginNames[$id] : null;
    }
}