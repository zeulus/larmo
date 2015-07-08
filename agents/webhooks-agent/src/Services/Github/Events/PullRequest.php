<?php

namespace FP\Larmo\Agents\WebHookAgent\Services\Github\Events;

class PullRequest extends EventAbstract
{
    protected function prepareMessages($dataObject)
    {
        $pullRequest = $dataObject->pull_request;

        $message = array(
            'type' => 'github.pull_request_' . $dataObject->action,
            'timestamp' => $pullRequest->updated_at,
            'author' => array(
                'login' => $pullRequest->user->login
            ),
            'body' => $dataObject->action . ' pull request',
            'extras' => array(
                'id' => $pullRequest->id,
                'number' => $pullRequest->number,
                'title' => $pullRequest->title,
                'body' => $pullRequest->body,
                'url' => $pullRequest->html_url
            )
        );

        return array($message);
    }
}
