<?php

$app['plugins'] = $app->share(function ($app) {
    $pluginsCollection = new \FP\Larmo\Domain\Service\PluginsCollection;
    $pluginsRepository = new \FP\Larmo\Infrastructure\Repository\FilesystemPlugins($app['config.path.plugins']);
    $pluginsRepository->retrieve($pluginsCollection);

    return new \FP\Larmo\Application\PluginService($pluginsCollection);
});

$app['mongo_db.storage'] = $app->share(function ($app) {
    $config = $app['config.mongo_db'];
    return new \FP\Larmo\Infrastructure\Adapter\MongoDbStorage($config['db_url'], $config['db_port'], $config['db_user'], $config['db_password'], $config['db_name'], $config['db_options']);
});

$app['messages.repository'] = $app->share(function ($app) {
    return new \FP\Larmo\Infrastructure\Repository\MongoDbMessages($app['mongo_db.storage']);
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