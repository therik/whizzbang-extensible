<?php
namespace WhizzBang;

interface RuleInterface {
    public function apply(ValueInterface $value): bool;
}