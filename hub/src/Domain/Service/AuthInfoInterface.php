<?php

namespace FP\Larmo\Domain\Service;

interface AuthInfoInterface
{
    public function validate($authInfo);
}
