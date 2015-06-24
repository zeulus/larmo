<?php

namespace FP\Larmo\Agents\WebHookAgent\Services\Github\Events;

class IssueComment extends EventAbstract
{
    protected function prepareMessages($dataObject)
    {
        $issue = $dataObject->issue;
        $comment = $dataObject->comment;

        $message = array(
            'type' => 'github.issue_comment_' . $dataObject->action,
            'timestamp' => strtotime($comment->updated_at),
            'author' => array(
                'login' => $comment->user->login
            ),
            'message' => $comment->user->login . ' ' . $dataObject->action . ' issue comment',
            'extras' => array(
                'id' => $comment->id,
                'issue_id' => $issue->id,
                'issue_title' => $issue->title,
                'message' => $comment->body,
                'url' => $comment->html_url
            )
        );

        return array($message);
    }
}
