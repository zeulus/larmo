<?php

namespace FP\Larmo\Agents\WebHookAgent\Services\Bitbucket\Events;

use FP\Larmo\Agents\WebHookAgent\Services\Bitbucket\EventInterface;

/**
 * Class Push
 * @package FP\Larmo\Agents\WebHookAgent\Services\Bitbucket\Events
 *
 * Handles pushed commits
 * Caution: BitBucket is not providing entirety of data in push report, only the last commit and information regarding
 * previous HEAD. Therefore, this event will not report all commits in a push, just the most recent one; this appears
 * to be intentional behaviour of BitBucket API
 *
 */
class RepoPush extends EventAbstract
{
    protected function prepareMessages($data)
    {
        $messages = array();

        foreach ($data->push->changes as $change) {
            array_push($messages, $this->getArrayFromCommit($change->new->target));
        }

        return $messages;
    }

    private function getArrayFromCommit($commit)
    {
        return array(
            'type' => 'bitbucket.commit',
            'timestamp' => strtotime($commit->date),
            'author' => array(
                'name' => $commit->author->user->display_name,
                'email' => $commit->author->raw,
                'login' => $commit->author->user->username
            ),
            'message' => $commit->author->user->display_name . ' added commit: "' . $commit->message . '"',
            'extras' => array(
                'message' => $commit->message,
                'url' => $commit->links->html->href,
                'hash' => $commit->hash
            )
        );
    }
}