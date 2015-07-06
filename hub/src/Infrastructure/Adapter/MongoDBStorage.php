<?php

namespace FP\Larmo\Infrastructure\Adapter;

class MongoDBStorage {
    private $connection;

    public function __construct($uri)
    {
        $credentials = '';
        if (isset($config['db_user']) && isset($config['db_password'])) {
            $credentials = "{$config['db_user']}:{$config['db_password']}@";
        }

        $uri = "mongodb://{$credentials}{$config['db_url']}:{$config['db_port']}/{$config['db_name']}";

        $client = new \MongoClient($uri);
        $this->db = $client->selectDB($config['db_name']);
    }
}