<?php

namespace FP\Larmo\Infrastructure\Service;


use FP\Larmo\Domain\Service\FiltersCollection;
use FP\Larmo\Domain\Service\MessageCollection;

interface MessageStorageProvider {

    public function store(MessageCollection $messages);
    public function setFilters(FiltersCollection $filters);
    public function retrieve(MessageCollection $messages);
}