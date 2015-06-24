<?php

use FP\Larmo\Agents\WebHookAgent\Services\Bitbucket\Events\RepoPush;
use FP\Larmo\Agents\WebHookAgent\Services\Bitbucket\Events\IssueCreated;
use FP\Larmo\Agents\WebHookAgent\Services\Bitbucket\Events\IssueUpdated;
use FP\Larmo\Agents\WebHookAgent\Services\Bitbucket\Events\IssueCommentCreated;

class BitbucketEventsTest extends PHPUnit_Framework_TestCase
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
        $push = new RepoPush($this->getDataObjectFromJson('InputData/bitbucket-push.json'));
        $expectedResult = json_decode($this->loadFile('OutputData/bitbucket-push.json'), true);
        $this->assertEquals($expectedResult, $push->getMessages());
    }

    /**
     * @test
     */
    public function issueCreatedEventReturnsCorrectData()
    {
        $issue = new IssueCreated($this->getDataObjectFromJson('InputData/bitbucket-issue_created.json'));
        $expectedResult = json_decode($this->loadFile('OutputData/bitbucket-issue_created.json'), true);
        $this->assertEquals($expectedResult, $issue->getMessages());
    }

    /**
     * @test
     */
    public function issueUpdatedEventReturnsCorrectData()
    {
        $issue = new IssueUpdated($this->getDataObjectFromJson('InputData/bitbucket-issue_updated.json'));
        $expectedResult = json_decode($this->loadFile('OutputData/bitbucket-issue_updated.json'), true);
        $this->assertEquals($expectedResult, $issue->getMessages());
    }

    /**
     * @test
     */
    public function issueCommentCreatedEventReturnsCorrectData()
    {
        $issue = new IssueCommentCreated($this->getDataObjectFromJson('InputData/bitbucket-issue_comment_created.json'));
        $expectedResult = json_decode($this->loadFile('OutputData/bitbucket-issue_comment_created.json'), true);
        $this->assertEquals($expectedResult, $issue->getMessages());
    }

}
