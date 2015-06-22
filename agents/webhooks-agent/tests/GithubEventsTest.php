<?php

use FP\Larmo\Agents\WebHookAgent\Services\Github\Events\Push;
use FP\Larmo\Agents\WebHookAgent\Services\Github\Events\CommitComment;

class GithubEventsTest extends PHPUnit_Framework_TestCase
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
        $push = new Push($this->getDataObjectFromJson('InputData/github-push.json'));
        $expectedResult = json_decode($this->loadFile('OutputData/github-push.json'), true);

        $this->assertEquals($expectedResult, $push->getMessages());
    }

    /**
     * @test
     */
    public function commitCommentEventReturnsCorrectData()
    {
        $commitComment = new CommitComment($this->getDataObjectFromJson('InputData/github-commit_comment.json'));
        $expectedResult = json_decode($this->loadFile('OutputData/github-commit_comment.json'), true);

        $this->assertEquals($expectedResult, $commitComment->getMessages());
    }
}

