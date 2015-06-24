<?php

require_once __DIR__ . '/../vendor/autoload.php';

$app = new Silex\Application;

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/mongo_config.php';

$pluginAdapter = new \FP\Larmo\Infrastructure\Adapter\FilesystemPluginsAdapter($app['pluginDirectory']);
$pluginCollection = new \FP\Larmo\Domain\Service\PluginsCollection();
$pluginRepository = new \FP\Larmo\Infrastructure\Repository\PluginsRepository($pluginAdapter);
$pluginRepository->registerPlugins($pluginCollection);
$pluginService = new \FP\Larmo\Application\PluginService($pluginCollection);

// e: after register plugins
// e: definition of app

require_once __DIR__ . '/../api/routes.php';
require_once __DIR__ . '/../api/error.php';

$app->run();