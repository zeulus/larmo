<?php

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

$app['filters.service'] = $app->share(function () {
   return new \FP\Larmo\Domain\Service\FiltersCollection;
});

$app['authinfo'] = $app->share(function ($app) {
    return new \FP\Larmo\Infrastructure\Adapter\IniFileAuthInfoProvider($app['authinfo_config']);
});

$app['packetValidation.service'] = function($app) {
    $retriever = new \JsonSchema\Uri\UriRetriever();
    $validator = new \JsonSchema\Validator();
    $authinfo = $app['authinfo'];
    $plugins = $app['plugins'];

    return new \FP\Larmo\Application\PacketValidationService($retriever, $validator, $authinfo, $plugins);
};