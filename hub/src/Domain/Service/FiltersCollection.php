<?php

namespace FP\Larmo\Domain\Service;

class FiltersCollection
{

    private $filters = array();

    public function __construct(array $filters = array())
    {
        $this->addFilters($filters);
    }

    public function addFilters(array $filters)
    {
        foreach ($filters as $filter) {
            $this->addFilter($filter);
        }
    }

    public function addFilter(MessageFilter $filter)
    {
        $this->filters[] = $filter;
    }

    public function execute(MessageCollection $messages)
    {

        foreach ($this->filters as $filter) {
            $filter->execute($messages);
        }
    }

    public function asArray()
    {
        return $this->filters;
    }
}