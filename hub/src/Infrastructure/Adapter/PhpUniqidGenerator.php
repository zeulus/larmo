<?php

namespace FP\Larmo\Infrastructure\Adapter;


use FP\Larmo\Application\Service\UniqueIdGenerator;

class PhpUniqidGenerator implements UniqueIdGenerator {

    public function generate()
    {
        return uniqid(null, true);
    }
}