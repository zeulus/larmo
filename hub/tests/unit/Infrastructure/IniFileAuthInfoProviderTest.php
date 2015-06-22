<?php

use org\bovigo\vfs\vfsStream;
use FP\Larmo\Infrastructure\Adapter\IniFileAuthInfoProvider;


class IniFileAuthInfoProviderTest extends PHPUnit_Framework_TestCase
{

    private $vfsRoot;
    private $fileCorrect, $fileBad;
    private $iniGood = <<<'EOD'
[someInfo]
somedata = somevalue

[authInfo]
agentXXX = "secret"
agentYYY = "even_more_secret"'
EOD;

    private $iniBad = <<<'EOD'
[not finished section
EOD;


    public function setup()
    {
        $this->vfsRoot = vfsStream::setup();
        $this->fileCorrect = vfsStream::newFile('good_auth.ini')->at($this->vfsRoot);
        $this->fileCorrect->setContent($this->iniGood);

        $this->fileBad = vfsStream::newFile('bad_auth.ini')->at($this->vfsRoot);
        $this->fileBad->setContent($this->iniBad);
    }

    /**
     * @test
     */
    public function requireValidIniFile()
    {
        $this->setExpectedException('FP\larmo\Domain\Exception\AuthInitException', 'Cannot parse auth file');
        $authProvider = new IniFileAuthInfoProvider($this->fileBad->url());
    }

    /**
     * @test
     */
    public function requireIniFileWithAuthSection()
    {
        // close the bracket so ini file is valid
        $this->iniBad .= ']';
        $this->fileBad->setContent($this->iniBad);
        $this->setExpectedException('FP\larmo\Domain\Exception\AuthInitException', 'Cannot find authInfo section');
        $authProvider = new IniFileAuthInfoProvider($this->fileBad->url());
    }

    /**
     * @test
     * @dataProvider authInfoTestData
     */
    public function requireProperAuthInfoParam($authInfo, $fail_description)
    {
        $authProvider = new IniFileAuthInfoProvider($this->fileCorrect->url());
        $this->assertFalse($authProvider->validate($authInfo), $fail_description);
    }

    public function authInfoTestData()
    {
        return [
          ['asdasd', 'string authInfo should fail to validate'],
          [['agentData'], 'auth info array should have proper structure'],
          [['agent' => 'data'], 'missing auth key in array should fail validation'],
          [['agent' => 'data', 'auth' => 'wrong'], 'wrong credentials should fail']
        ];
    }

    /**
     * @test
     */
    public function validationPassedWithExistingCredentials()
    {
        $authInfo = ['agent' => 'agentXXX', 'auth' => 'secret'];
        $authProvider = new IniFileAuthInfoProvider($this->fileCorrect->url());
        $this->assertTrue($authProvider->validate($authInfo), 'proper credentials should pass the validation');
    }
}