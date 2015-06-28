<?php

$app['plugins'] = $app->share(function ($app) {
    $pluginAdapter = new \FP\Larmo\Infrastructure\Adapter\FilesystemPluginsAdapter($app['config.path.plugins']);
    $pluginCollection = new \FP\Larmo\Domain\Service\PluginsCollection();
    $pluginRepository = new \FP\Larmo\Infrastructure\Repository\PluginsRepository($pluginAdapter);
    $pluginRepository->registerPlugins($pluginCollection);

    return new \FP\Larmo\Application\PluginService($pluginCollection);
});

$app['messages.repository'] = $app->share(function ($app) {
    $messageProvider = new \FP\Larmo\Infrastructure\Adapter\MongoMessageStorageProvider($app['config.mongo_db']);

    return new \FP\Larmo\Infrastructure\Repository\MessageRepository($messageProvider);
});

$app['messages.factory'] = $app->share(function () {
    return new \FP\Larmo\Infrastructure\Factory\MessageCollection;
});

$app['filters.service'] = $app->share(function () {
    return new \FP\Larmo\Domain\Service\FiltersCollection;
});

$app['authinfo'] = $app->share(function ($app) {
    return new \FP\Larmo\Infrastructure\Adapter\IniFileAuthInfoProvider($app['config.path.authinfo']);
});

$app['json_schema_validation'] = function () {
    return new \FP\Larmo\Application\Adapter\VendorJsonSchemaValidation;
};

$app['packet_validation.service'] = function ($app) {
    $validator = $app['json_schema_validation'];
    $authinfo = $app['authinfo'];
    $plugins = $app['plugins'];

    return new \FP\Larmo\Application\PacketValidationService($validator, $authinfo, $plugins);
};