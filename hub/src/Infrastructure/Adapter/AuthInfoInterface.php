<?php

namespace FP\Larmo\Infrastructure\Adapter;

interface AuthInfoInterface {
    public function __construct($authInfo);
    public function validate($authInfoToValidate);
}
