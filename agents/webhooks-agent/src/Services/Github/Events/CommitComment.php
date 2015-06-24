<?php

namespace FP\Larmo\Agents\WebHookAgent\Services\Github\Events;

class CommitComment extends EventAbstract
{

    protected function prepareMessages($dataObject)
    {
        $comment = $dataObject->comment;

        $message = array(
            'type' => 'github.created_commit_comment',
            'timestamp' => strtotime($comment->created_at),
            'author' => array(
                'login' => $comment->user->login
            ),
            'message' => $comment->user->login . ' created commit comment',
            'extras' => array(
                'id' => $comment->id,
                'message' => $comment->body,
                'url' => $comment->html_url,
                'commit_id' => $comment->commit_id
            )
        );

        return array($message);
    }

}