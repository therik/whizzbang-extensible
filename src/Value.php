<?php
namespace WhizzBang;

class Value implements ValueInterface{
    private $value;

    public function __construct($value) {
        $this->value = $value;
    }

    public function getValue() {
        return $this->value;
    }

    public function getOriginalObject() {
        return $this;
    }
}