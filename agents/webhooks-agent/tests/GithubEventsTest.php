<?php

use FP\Larmo\Agents\WebHookAgent\Services\Github\Events\Push;
use FP\Larmo\Agents\WebHookAgent\Services\Github\Events\CommitComment;
use FP\Larmo\Agents\WebHookAgent\Services\Github\Events\PullRequest;
use FP\Larmo\Agents\WebHookAgent\Services\Github\Events\Issues;
use FP\Larmo\Agents\WebHookAgent\Services\Github\Events\IssueComment;

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

    /**
     * @test
     */
    public function pullRequestEventReturnsCorrectData()
    {
        $pullRequest = new PullRequest($this->getDataObjectFromJson('InputData/github-pull_request.json'));
        $expectedResult = json_decode($this->loadFile('OutputData/github-pull_request.json'), true);

        $this->assertEquals($expectedResult, $pullRequest->getMessages());
    }

    /**
     * @test
     */
    public function issueEventReturnsCorrectData()
    {
        $issue = new Issues($this->getDataObjectFromJson('InputData/github-issue.json'));
        $expectedResult = json_decode($this->loadFile('OutputData/github-issue.json'), true);

        $this->assertEquals($expectedResult, $issue->getMessages());
    }

    /**
     * @test
     */
    public function issueCommentEventReturnsCorrectData()
    {
        $issueComment = new IssueComment($this->getDataObjectFromJson('InputData/github-issue_comment.json'));
        $expectedResult = json_decode($this->loadFile('OutputData/github-issue_comment.json'), true);

        $this->assertEquals($expectedResult, $issueComment->getMessages());
    }
}

