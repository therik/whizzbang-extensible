<?php
namespace WhizzBang;

class AndRule implements RuleInterface{
    private $rules = [];

    public function __construct(RuleInterface... $rules) {
        $this->rules = $rules;
    }

    public function apply(ValueInterface $value): bool{
        foreach ($this->rules as $rule) {
            if (! $rule->apply($value)) {
                return false;
            }
        }

        return true;
    }
}