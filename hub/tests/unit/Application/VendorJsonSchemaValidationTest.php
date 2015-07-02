<?php

use FP\Larmo\Application\Adapter\VendorJsonSchemaValidation;

class VendorJsonSchemaValidationeTest extends PHPUnit_Framework_TestCase
{
    private $jsonValidator;

    public function setup()
    {
        $this->jsonValidator = new VendorJsonSchemaValidation();
    }

    /**
     * @test
     */
    public function getErrorsOutputArray()
    {
        $this->assertTrue(is_array($this->jsonValidator->getErrors()));
    }

    /**
     * @test
     */
    public function isValidReturnsCorrectValue()
    {
        $this->assertEquals(1, $this->jsonValidator->isValid());
    }
}
