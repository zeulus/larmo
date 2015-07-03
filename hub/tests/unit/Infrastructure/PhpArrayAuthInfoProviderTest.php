<?php

use FP\Larmo\Infrastructure\Adapter\PhpArrayAuthInfoProvider;

class PhpArrayAuthInfoProviderTest extends PHPUnit_Framework_TestCase
{
    private $authProvider;

    protected function setUp()
    {
        $this->authProvider = new PhpArrayAuthInfoProvider(['testAgent' => 'secretKey']);
    }

    /**
     * @test
     */
    public function validationFailedWhenGivenInvalidAuthinfoStructure()
    {
        $this->assertFalse($this->authProvider->validate([]),
            'invalid structure of authinfo should fail the validation');
    }

    /**
     * @test
     */
    public function validationFailedWhenGivenInvalidAgent()
    {
        $authinfo = ['agent' => 'invalidAgent', 'auth' => 'secretKey'];

        $this->assertFalse($this->authProvider->validate($authinfo),
            'invalid agent name should fail the validation');
    }

    /**
     * @test
     */
    public function validationFailedWhenGivenInvalidAuthKey()
    {
        $authinfo = ['agent' => 'testAgent', 'auth' => 'invalidSecretKey'];

        $this->assertFalse($this->authProvider->validate($authinfo),
            'invalid secret key for agent should fail the validation');
    }

    /**
     * @test
     */
    public function validationPassedWithExistingCredentials()
    {
        $authinfo = ['agent' => 'testAgent', 'auth' => 'secretKey'];

        $this->assertTrue($this->authProvider->validate($authinfo),
            'proper credentials should pass the validation');
    }
}