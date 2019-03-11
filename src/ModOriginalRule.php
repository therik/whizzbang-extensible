<?php
namespace WhizzBang;

class ModOriginalRule implements RuleInterface {
    private $modVal;
    
    public function __construct(int $modVal) {
        $this->modVal = $modVal;
    }

    public function apply(ValueInterface $value): bool {
        return $value->getOriginalObject()->getValue() % $this->modVal === 0;
    }
}