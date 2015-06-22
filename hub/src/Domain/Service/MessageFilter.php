<?php

namespace FP\Larmo\Domain\Service;


interface MessageFilter
{

    public function setConstraints();

    public function execute();

    public function filterQuery();
}