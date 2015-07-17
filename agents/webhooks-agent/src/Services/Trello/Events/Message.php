<?php

namespace FP\Larmo\Agents\WebHookAgent\Services\Trello\Events;

class Message extends EventAbstract
{

    protected function prepareMessages($dataObject)
    {
        $messageArray = $this->getArrayFromMessage($dataObject);
        return [$messageArray];
    }

    protected function getArrayFromMessage($message)
    {
        $model = $message->model;
        $action = $message->action;

        return array(
            'type' => 'trello.message',
            'timestamp' => strtotime($action->date),
            'author' => array(
                'name' => $action->memberCreator->fullName,
                'login' => $action->memberCreator->username
            ),
            'body' => $action->memberCreator->fullName.' performed '.$action->type,
            'extras' => array(
                'id' => $action->id,
                'url' => $model->url,
                'action' => $action->type
            )
        );
    }

}