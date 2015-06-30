<?php

namespace FP\Larmo\Application\Adapter;

use JsonSchema\Validator;
use FP\Larmo\Application\Contract\JsonSchemaValidation as JsonSchemaValidationContract;

class VendorJsonSchemaValidation implements JsonSchemaValidationContract
{
    private $validator;

    public function __construct()
    {
        $this->validator = new Validator;
    }

    public function check($value, $schema)
    {
        $this->validator->check($value, $schema);
    }

    public function isValid()
    {
        return $this->validator->isValid();
    }

    /**
     * Should return array of errors:
     * [[
     *   'property' => 'metadata.authinfo',
     *   'message' => 'the authinfo is invalid'
     * ], [ ... ]]
     *
     * @return array
     */
    public function getErrors()
    {
        return $this->validator->getErrors();
    }
}