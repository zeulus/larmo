<?php

namespace FP\Larmo\Agents\WebHookAgent\Services\Github\Events;

class Push extends EventAbstract
{

    protected function prepareMessages($dataObject)
    {
        $messages = array();

        foreach ($dataObject->commits as $commit) {
            array_push($messages, $this->getArrayFromCommit($commit));
        }

        return $messages;
    }

    protected function getArrayFromCommit($commit)
    {
        return array(
            'type' => 'commit',
            'timestamp' => $commit->timestamp,
            'author' => array(
                'name' => $commit->author->name,
                'email' => $commit->author->email,
                'login' => $commit->author->username
            ),
            'message' => $commit->author->name . ' added commit: "' . $commit->message . '"',
            'extras' => array(
                'id' => $commit->id,
                'files' => array(
                    'added' => $commit->added,
                    'removed' => $commit->removed,
                    'modified' => $commit->modified
                ),
                'message' => $commit->message,
                'url' => $commit->url
            )
        );
    }

}