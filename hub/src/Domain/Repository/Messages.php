<?php

namespace FP\Larmo\Domain\Repository;

use FP\Larmo\Domain\Service\FiltersCollection;
use FP\Larmo\Domain\Service\MessageCollection;

interface Messages
{
    /**
     * @param MessageCollection $messages
     */
    public function store(MessageCollection $messages);

    /**
     * @param MessageCollection $messages
     * @param FiltersCollection $filters
     * @return MessageCollection
     */
    public function retrieve(MessageCollection $messages, FiltersCollection $filters = null);
}