<?php

$app['plugins'] = $app->share(function ($app) {
    $pluginAdapter = new \FP\Larmo\Infrastructure\Adapter\FilesystemPluginsAdapter($app['plugins_directory']);
    $pluginCollection = new \FP\Larmo\Domain\Service\PluginsCollection();
    $pluginRepository = new \FP\Larmo\Infrastructure\Repository\PluginsRepository($pluginAdapter);
    $pluginRepository->registerPlugins($pluginCollection);

    return new \FP\Larmo\Application\PluginService($pluginCollection);
});

$app['authinfo'] = $app->share(function ($app) {
    return new \FP\Larmo\Infrastructure\Adapter\IniFileAuthInfoProvider($app['authinfo_config']);
});