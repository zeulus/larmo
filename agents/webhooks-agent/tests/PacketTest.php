<?php

use FP\Larmo\Agents\WebHookAgent\Packet;
use FP\Larmo\Agents\WebHookAgent\Services\Github\GithubData;

class PacketTest extends PHPUnit_Framework_TestCase
{
    private $service;
    private $packet;

    public function setup()
    {
        $_SERVER['HTTP_X_GITHUB_EVENT'] = 'push';
        $this->service = new GithubData($this->getDataObjectFromJson());
        $this->packet = new Packet($this->service);
    }


    private function loadFile($fileName)
    {
        return file_get_contents($fileName);
    }

    private function getDataObjectFromJson()
    {
        if($json = $this->loadFile('InputData/github-push.json')) {
            return json_decode($json);
        }

        return null;
    }

    /**
     * @test
     */
    public function packetHasCorrectStructure()
    {
        $result = json_decode($this->packet->send(), true);
        $this->assertArrayHasKey('metadata', $result);
        $this->assertArrayHasKey('data', $result);
    }

    /**
     * @test
     */
    public function packetHasCorrectMessages()
    {
        $exprectedResult = json_decode($this->loadFile('OutputData/github-push.json'), true);
        $result = json_decode($this->packet->send(), true);

        $this->assertEquals($exprectedResult, $result['data']);
    }
}
