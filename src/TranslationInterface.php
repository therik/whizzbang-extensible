<?php
namespace WhizzBang;

interface TranslationInterface extends ValueInterface{
    public function getValue();
    public function setValue(ValueInterface $originalValue);
}