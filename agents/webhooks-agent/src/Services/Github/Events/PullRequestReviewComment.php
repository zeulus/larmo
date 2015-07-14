<?php

namespace FP\Larmo\Agents\WebHookAgent\Services\Github\Events;

class PullRequestReviewComment extends EventAbstract
{
    protected function prepareMessages($dataObject)
    {
        $comment = $dataObject->comment;
        $pullRequest = $dataObject->pull_request;

        $message = array(
            'type' => 'github.pull_request_review_comment_' . $dataObject->action,
            'timestamp' => $comment->updated_at,
            'author' => array(
                'login' => $comment->user->login
            ),
            'body' => $dataObject->action . ' pull request review comment',
            'extras' => array(
                'id' => $comment->id,
                'body' => $comment->body,
                'pull_request_number' => $pullRequest->number,
                'pull_request_url' => $pullRequest->html_url,
                'url' => $comment->html_url
            )
        );

        return array($message);
    }
}
