<?php

use FP\Larmo\Agents\WebHookAgent\Request;

class RequestTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function decoderFailsOnNonJsonFiles()
    {
        $this->setExpectedException("FP\\Larmo\\Agents\\WebHookAgent\\Exceptions\\InvalidIncomingDataException");
        $request = new Request($_SERVER, "NOT JSON");
        $request->getDecodedPayload();
    }

    /**
     * @test
     */
    public function payloadIsMatching()
    {
        $testString = "STRING";
        $request = new Request($_SERVER, $testString);

        $this->assertEquals($testString, $request->getPayload());
    }

    /**
     * @test
     */
    public function UriIsReadProperly()
    {
        $testUri = 'test/uri';
        $request = new Request(['REQUEST_URI' => $testUri], "");

        $this->assertEquals($testUri, $request->getUri());
    }

    /**
     * @test
     */
    public function requestMethodIsRecognisedProperlyIfWrong()
    {
        $request = new Request(['REQUEST_METHOD' => 'GET'], "");
        $this->assertFalse($request->isPostMethod());
    }

    /**
     * @test
     */
    public function requestMethodIsRecognisedProperlyIfRight()
    {
        $request = new Request(['REQUEST_METHOD' => 'POST'], "");
        $this->assertTrue($request->isPostMethod());
    }

    /**
     * @test
     */
    public function headersAreReturnedProperly()
    {
        $headers = ['REQUEST_METHOD' => 'GET', 'SERVER_NAME' => '127.0.0.1', 'REQUEST_URI' => 'uri/test'];
        $request = new Request($headers, "");
        $this->assertEquals($headers, $request->getHeaders());
    }
}
