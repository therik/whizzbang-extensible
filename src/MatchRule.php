<?php
namespace WhizzBang;

class MatchRule implements RuleInterface {
    private $matchValue;
    
    public function __construct($matchValue) {
        $this->matchValue = $matchValue;
    }

    public function apply(ValueInterface $value): bool {
        return $value->getValue() === $this->matchValue;
    }
}