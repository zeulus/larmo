<?php

use FP\Larmo\Agents\WebHookAgent\Services\Trello\Events\Message;

class TrelloEventsTest extends PHPUnit_Framework_TestCase
{
    private function loadFile($fileName)
    {
        return file_get_contents($fileName);
    }

    private function getDataObjectFromJson($fileName)
    {
        if($json = $this->loadFile($fileName)) {
            return json_decode($json);
        }

        return null;
    }

    /**
     * @test
     */
    public function eventReturnsCorrectData()
    {
        $message = new Message($this->getDataObjectFromJson(dirname(__FILE__).'/InputData/trello-message.json'));
        $expectedResult = json_decode($this->loadFile(dirname(__FILE__).'/OutputData/trello-message.json'), true);

        $this->assertEquals($expectedResult, $message->getMessages());
    }

}

