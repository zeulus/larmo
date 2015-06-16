<?php

namespace FP\Larmo;


interface AuthInfoInterface {
    public function __construct();
    public function validate();
}