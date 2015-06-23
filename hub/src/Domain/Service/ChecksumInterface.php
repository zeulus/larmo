<?php

namespace FP\Larmo\Domain\Service;

interface ChecksumInterface
{
    public function validate($checksum);
}
