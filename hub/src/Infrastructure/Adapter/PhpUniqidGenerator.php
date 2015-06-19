<?php

namespace FP\Larmo\Infrastructure\Adapter;

use FP\Larmo\Domain\Service\UniqueIdGenerator;

class PhpUniqidGenerator implements UniqueIdGenerator
{

    public function generate()
    {
        return uniqid(null, true);
    }
}