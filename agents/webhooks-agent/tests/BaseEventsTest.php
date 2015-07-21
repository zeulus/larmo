<?php

abstract class BaseEventsTest extends PHPUnit_Framework_TestCase
{
    protected function loadFile($fileName)
    {
        return file_get_contents($fileName);
    }

    protected function getDataObjectFromJson($fileName)
    {
        if($json = $this->loadFile($fileName)) {
            return json_decode($json);
        }

        return null;
    }
}
