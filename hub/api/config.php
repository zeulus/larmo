<?php

$setupConfig = function() use ($app) {
    $config_directory = __DIR__ . '/../config/';
    $files = scandir($config_directory);

    foreach ($files as $file) {
        if (pathinfo($file, PATHINFO_EXTENSION) === 'php' && $file !== 'parameters.php') {
            require_once $config_directory . $file;
        }
    }

    if (file_exists($config_directory . 'parameters.php')) {
        require_once $config_directory . 'parameters.php';
    }
};

$setupConfig();