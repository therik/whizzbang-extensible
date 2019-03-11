<?php
namespace WhizzBang;

class NotRule implements RuleInterface {
    private $rule;
    
    public function __construct(RuleInterface $rule) {
        $this->rule = $rule;
    }

    public function apply(ValueInterface $value): bool{
        return ! $this->rule->apply($value);
    }
}