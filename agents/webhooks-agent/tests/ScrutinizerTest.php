<?php

use FP\Larmo\Agents\WebHookAgent\Services\Scrutinizer\ScrutinizerData;

class ScrutinizerTest extends PHPUnit_Framework_TestCase
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
    public function pushEventReturnsCorrectData()
    {
        $scrutinizer = new ScrutinizerData(
            $this->getDataObjectFromJson(dirname(__FILE__).'/InputData/scrutinizer.json'),
            array('X-Scrutinizer-Event' => 'completed')
        );

        $expectedResult = json_decode($this->loadFile(dirname(__FILE__).'/OutputData/scrutinizer.json'), true);

        $this->assertEquals($expectedResult, $scrutinizer->getData());
    }
}
