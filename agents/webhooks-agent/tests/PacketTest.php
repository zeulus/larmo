<?php

use FP\Larmo\Agents\WebHookAgent\Packet;
use FP\Larmo\Agents\WebHookAgent\Metadata;
use FP\Larmo\Agents\WebHookAgent\Services\Github\GithubData;

class PacketTest extends PHPUnit_Framework_TestCase
{
    private $packet;
    private $errorCatched;

    public function setup()
    {
        $this->errorCatched = false;
        set_error_handler(array($this, 'errorHandler'));
        $service = new GithubData($this->getDataObjectFromJson(), array('HTTP_X_GITHUB_EVENT' => 'push'));
        $metadata = new Metadata($service->getServiceName(), "AUTHENTICATION_KEY");
        $this->packet = new Packet($metadata, $service);
    }


    private function loadFile($fileName)
    {
        return file_get_contents($fileName);
    }

    private function getDataObjectFromJson()
    {
        if($json = $this->loadFile(dirname(__FILE__).'/InputData/github-push.json')) {
            return json_decode($json);
        }

        return null;
    }

    public function errorHandler($errNo, $msg)
    {
        $this->errorCatched = true;
        file_put_contents('php://stderr', $msg . "\n");
    }

    /**
     * @test
     */
    public function wrongUriThrowError()
    {
        $this->setExpectedException('FP\Larmo\Agents\WebHookAgent\Exceptions\InvalidConfigurationException');
        $this->packet->send('');
    }

    /**
     * @test
     */
    public function sendPacketWithoutErrors()
    {
        $this->packet->send('localhost');
        $this->assertEquals(false, $this->errorCatched);
    }

    /**
     * @test
     */
    public function packetHasCorrectStructure()
    {
        $result = $this->packet->getPacket();
        $this->assertArrayHasKey('metadata', $result);
        $this->assertArrayHasKey('data', $result);
    }

    /**
     * @test
     */
    public function packetHasCorrectMessages()
    {
        $expectedResult = json_decode($this->loadFile(dirname(__FILE__).'/OutputData/github-push.json'), true);
        $result = $this->packet->getPacket();

        $this->assertEquals($expectedResult, $result['data']);
    }
}
