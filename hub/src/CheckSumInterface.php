<?php
/**
 * Created by PhpStorm.
 * User: mlabedowicz
 * Date: 2015-06-16
 * Time: 11:54
 */

namespace FP\Larmo;


interface  CheckSumInterface
{
    public function __construct($source, $timestamp, $numberOfMessages);
    public function validate($checksumToValidate);
}