<?php

namespace FP\Larmo\Agents\WebHookAgent\Services\Scrutinizer;

use FP\Larmo\Agents\WebHookAgent\Services\ServiceAbstract;
use FP\Larmo\Agents\WebHookAgent\Exceptions\EventTypeNotFoundException;

class ScrutinizerData extends ServiceAbstract
{
    public function __construct($data, $requestHeaders = null)
    {
        $this->serviceName = 'scrutinizer';
        $this->eventHeader = 'X-Scrutinizer-Event';
        $this->eventType = $this->getEventType($requestHeaders);
        $this->data = $this->prepareData($data);
    }

    protected function prepareData($data)
    {
        if($data->state === 'completed') {
            $diff = $data->_embedded->index_diff;

            $message = array(
                'type' => 'scrutinizer.' . $data->state,
                'timestamp' => $data->finished_at,
                'author' => array(),
                'body' => 'Scrutinizer CI inspection',
                'extras' => array(
                    'id' => $data->uuid,
                    'repository' => array(
                        'user' => isset($data->metadata->source) ? $data->metadata->source->login : $data->_embedded->repository->login,
                        'branch' => isset($data->metadata->source) ? $data->metadata->source->branch : $data->metadata->branch,
                        'name' => isset($data->metadata->source) ? $data->metadata->source->repository : $data->_embedded->repository->name
                    ),
                    'pull_request_number' => isset($data->pull_request_number) ? $data->pull_request_number : '',
                    'status' => $data->build->status,
                    'results' => array(
                        'new_issues' => $diff->nb_new_issues,
                        'common_issues' => $diff->nb_common_issues,
                        'fixed_issues' => $diff->nb_new_issues,
                        'added_code_elements' => $diff->nb_added_code_elements,
                        'common_code_elements' => $diff->nb_common_code_elements,
                        'changed_code_elements' => $diff->nb_changed_code_elements,
                        'removed_code_elements' => $diff->nb_removed_code_elements
                    )
                )
            );
        } else {
            throw new EventTypeNotFoundException;
        }

        return array($message);
    }
}
