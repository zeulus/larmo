<?php

namespace FP\Larmo\Agents\WebHookAgent\Services\Gitlab\Events;

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
            'timestamp' => strtotime($commit->timestamp),
            'author' => array(
                'name' => $commit->author->name,
                'email' => $commit->author->email
            ),
            'message' => $commit->author->name . ' added commit: "' . $commit->message . '"',
            'extras' => array(
                'id' => $commit->id,
                'message' => $commit->message,
                'url' => $commit->url
            )
        );
    }

}
