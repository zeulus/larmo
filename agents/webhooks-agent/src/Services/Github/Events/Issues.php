<?php

namespace FP\Larmo\Agents\WebHookAgent\Services\Github\Events;

class Issues extends EventAbstract
{
    protected function prepareMessages($dataObject)
    {
        $issue = $dataObject->issue;

        $message = array(
            'type' => 'issue_' . $dataObject->action,
            'timestamp' => strtotime($issue->updated_at),
            'author' => array(
                'login' => $issue->user->login
            ),
            'message' => $issue->user->login . ' ' . $dataObject->action . ' issue',
            'extras' => array(
                'id' => $issue->id,
                'number' => $issue->number,
                'title' => $issue->title,
                'message' => $issue->body,
                'url' => $issue->html_url
            )
        );

        return array($message);
    }
}
