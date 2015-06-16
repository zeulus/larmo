<?php
/**
 * Created by PhpStorm.
 * User: zeulus
 * Date: 15.06.15
 * Time: 15:21
 */

namespace FP\Larmo;


use Prophecy\Exception\InvalidArgumentException;

class Message {

    private $type;
    private $timestamp;
    private $author;

    public function __construct($type, $timestamp, $author) {
        $this->type = $type;
        $this->timestamp = $timestamp;
        $this->author = $author;
    }

    public function getType() {
        return $this->type;
    }

    public function getTimestamp() {
        return $this->timestamp;
    }

    public function setTimestamp($timestamp) {
        if(is_int($timestamp) && $timestamp >= 0) {
            $this->timestamp = $timestamp;
        } else {
            throw new \InvalidArgumentException;
        }

    }

    public function getAuthor() {
        return $this->author;
    }
}