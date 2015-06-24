<?php

namespace FP\Larmo\Infrastructure\Adapter;

use FP\Larmo\Domain\Service\FiltersCollection;
use FP\Larmo\Domain\Service\MessageCollection;
use FP\Larmo\Infrastructure\Service\MessageStorageProvider;

class MongoDbStorageProvider implements MessageStorageProvider {
    private $db;

    public function __construct($config)
    {
        $uri = "mongodb://{$config['db_user']}:{$config['db_password']}@{$config['db_url']}:{$config['db_port']}/{$config['db_name']}";
        $client = new \MongoClient($uri);
        $this->db = $client->selectDB($config['db_name']);
    }

    public function store(MessageCollection $messages)
    {
        $this->db->messages->batchInsert($messages);
    }

    public function setFilters(FiltersCollection $filters)
    {

    }

    public function retrieve(MessageCollection $messages)
    {
        return $this->db->messages->find();
    }
}
