<?php

namespace FP\Larmo\Agents\WebHookAgent\Services\Github\Events;

class Push extends EventAbstract
{

    protected function prepareMessages($dataObject)
    {
        $messages = array();
        $extras = $this->getExtrasData($dataObject);

        foreach ($dataObject->commits as $commit) {
            $commitArray = $this->getArrayFromCommit($commit);
            array_push($commitArray['extras'], $extras);
            array_push($messages, $commitArray);
        }

        return $messages;
    }

    private function getExtrasData($push)
    {
        return array(
            'branch' => str_replace('refs/heads/', '', $push->ref),
            'repository' => array(
                'id' => $push->repository->id,
                'name' => $push->repository->name,
                'full_name' => $push->repository->full_name,
            ),
        );
    }

    protected function getArrayFromCommit($commit)
    {
        return array(
            'type' => 'github.commit',
            'timestamp' => $commit->timestamp,
            'author' => array(
                'name' => $commit->author->name,
                'email' => $commit->author->email,
                'login' => $commit->author->username
            ),
            'body' => 'added commit',
            'extras' => array(
                'id' => $commit->id,
                'files' => array(
                    'added' => $commit->added,
                    'removed' => $commit->removed,
                    'modified' => $commit->modified
                ),
                'body' => $commit->message,
                'url' => $commit->url
            )
        );
    }

}