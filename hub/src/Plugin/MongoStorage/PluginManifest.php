<?php

namespace FP\Larmo\Plugin\MongoStorage;

use FP\Larmo\Domain\Service\PluginManifestInterface;

final class PluginManifest implements PluginManifestInterface
{
    private $ident = 'mongodb';
    private $name = 'MongoDB Storage';

    /**
     * @var array
     */
    private $config;

    /**
     * @var MongoDbStorage
     */
    private $storage;

    /**
     * @var MongoDbMessages
     */
    private $repository;

    /**
     * @todo load config from file
     * @todo lazy loading for storage / repository
     */
    public function __construct()
    {
        $this->config = [
            'db_user' => getenv('MONGO_DB_USER'),
            'db_password' => getenv('MONGO_DB_PASSWORD'),
            'db_url' => getenv('MONGO_DB_URL'),
            'db_name' => getenv('MONGO_DB_NAME'),
            'db_port' => getenv('MONGO_DB_PORT'),
            'db_options' => []
        ];

        $this->storage = new MongoDbStorage(
            $this->config['db_url'],
            $this->config['db_port'],
            $this->config['db_user'],
            $this->config['db_password'],
            $this->config['db_name'],
            $this->config['db_options']
        );

        $this->repository = new MongoDbMessages($this->storage);
    }


    public function getIdentifier()
    {
        return $this->ident;
    }

    /**
     * @return EventSubscriber
     */
    public function getEventSubscriber()
    {
        return new EventSubscriber($this->repository);
    }

    public function getDisplayName()
    {
        return $this->name;
    }
}