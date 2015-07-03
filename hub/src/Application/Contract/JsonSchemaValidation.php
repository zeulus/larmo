<?php

namespace FP\Larmo\Application\Contract;

interface JsonSchemaValidation
{
    public function check($value, $schema);

    public function isValid();

    public function getErrors();
}