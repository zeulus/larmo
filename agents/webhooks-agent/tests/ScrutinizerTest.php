<?php

use FP\Larmo\Agents\WebHookAgent\Services\Scrutinizer\ScrutinizerData;

class ScrutinizerTest extends BaseEventsTest
{
    /**
     * @test
     */
    public function scrutinizerReturnsCorrectData()
    {
        $scrutinizer = new ScrutinizerData(
            $this->getDataObjectFromJson(dirname(__FILE__).'/InputData/scrutinizer.json'),
            array('X-Scrutinizer-Event' => 'completed')
        );

        $expectedResult = json_decode($this->loadFile(dirname(__FILE__).'/OutputData/scrutinizer.json'), true);

        $this->assertEquals($expectedResult, $scrutinizer->getData());
    }
}
