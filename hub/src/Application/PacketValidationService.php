<?php

namespace FP\Larmo\Application;

final class PacketValidationService
{
    private $schema;
    private $packet;
    private $retriever;
    private $validator;
    private $authinfo;
    private $plugins;
    private $errors = [];

    public function __construct($schemaRetriver, $schemaValidator, $authinfo, $plugins)
    {
        $this->retriever = $schemaRetriver;
        $this->validator = $schemaValidator;
        $this->authinfo = $authinfo;
        $this->plugins = $plugins;
    }

    public function setSchemaFromFile($schemaFilePath)
    {
        $this->schema = $this->retriever->retrieve($schemaFilePath);

        return $this;
    }

    public function setPacket($packet)
    {
        $this->packet = $packet;

        return $this;
    }

    public function isValid()
    {
        $this->errors = [];
        $this->validator->check($this->packet, $this->schema);

        if (!$this->validator->isValid()) {
            $this->errors = $this->validator->getErrors();

            return false;
        }

        if (!$this->authinfo->validate(get_object_vars($this->packet->metadata->authinfo))) {
            $this->errors[] = [
                'property' => 'metadata.authinfo',
                'message' => 'the authinfo is invalid'
            ];

            return false;
        }

        if (!$this->plugins->checkPluginIsRegistered($this->packet->metadata->source)) {
            $this->errors[] = [
                'property' => 'metadata.source',
                'message' => 'the source is invalid'
            ];

            return false;
        }

        return true;
    }

    public function getErrors()
    {
        return $this->errors;
    }
}