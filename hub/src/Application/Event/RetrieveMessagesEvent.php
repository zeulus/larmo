<?php

namespace FP\Larmo\Application\Event;

use FP\Larmo\Domain\Service\FiltersCollection;

final class RetrieveMessagesEvent extends MessagesBaseEvent
{
    /**
     * @var FiltersCollection
     */
    private $filters;

    /**
     * @return FiltersCollection
     */
    public function getFilters()
    {
        return $this->filters;
    }

    /**
     * @param FiltersCollection $filters
     */
    public function setFilters(FiltersCollection $filters)
    {
        $this->filters = $filters;
    }
}