<?php

namespace FP\Larmo\Agents\WebHookAgent\Services\Bitbucket\Events;

class IssueCreated extends EventAbstract
{
    protected function prepareMessages($data)
    {
        $issue = $data->issue;

        $message = array(
            'type' => 'bitbucket.issue_created',
            'timestamp' => strtotime($issue->created_on),
            'author' => array(
                'login' => $issue->reporter->username,
                'name' => $issue->reporter->display_name,
            ),
            'body' => $issue->reporter->display_name . ' has created "' . $issue->title . '" issue',
            'extras' => array(
                'id' => $issue->id,
                'priority' => $issue->priority,
                'title' => $issue->title,
                'body' => $issue->content->raw,
                'html' => $issue->content->html,
                'url' => $issue->links->html->href,
                'attachments' => $issue->links->attachments->href,
                'votes' => $issue->votes,
                'watches' => $issue->watches,
                'type' => $issue->kind,
                'assignee' => array(
                    'login' => $issue->assignee->username,
                    'name' => $issue->assignee->display_name,
                ),
            )
        );

        return array($message);
    }
}