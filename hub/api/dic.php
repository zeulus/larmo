<?php

use fkooman\Json\Json;

$app['plugins'] = $app->share(function ($app) {
    $pluginAdapter = new \FP\Larmo\Infrastructure\Adapter\FilesystemPluginsAdapter($app['plugins_directory']);
    $pluginCollection = new \FP\Larmo\Domain\Service\PluginsCollection();
    $pluginRepository = new \FP\Larmo\Infrastructure\Repository\PluginsRepository($pluginAdapter);
    $pluginRepository->registerPlugins($pluginCollection);

    return new \FP\Larmo\Application\PluginService($pluginCollection);
});

$app['messages.repository'] = $app->share(function ($app) {
    $messageProvider = new \FP\Larmo\Infrastructure\Adapter\MongoMessageStorageProvider($app['mongo_db']);
    return new \FP\Larmo\Infrastructure\Repository\MessageRepository($messageProvider);
});

$app['messages.factory'] = $app->share(function () {
    return new \FP\Larmo\Infrastructure\Factory\MessageCollection;
});

$app['authinfo'] = $app->share(function ($app) {
    return new \FP\Larmo\Infrastructure\Adapter\IniFileAuthInfoProvider($app['authinfo_config']);
});

$app['json_parse'] = $app->protect(function ($json) {
    if ($json) {
        try {
            return Json::decode($json);
        } catch (InvalidArgumentException $exception) {
            return false;
        }
    }

    return false;
});