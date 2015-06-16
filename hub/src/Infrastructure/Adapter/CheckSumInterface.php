<?php

namespace FP\Larmo\Infrastructure\Adapter;

interface CheckSumInterface {
    public function __construct($source, $timestamp, $numberOfMessages);
    public function validate($checksumToValidate);
}
