<?php
namespace WhizzBang;

class WhizzBang
{
    private $ruleTuples = [];
    private $valuesIterator = null;
    private $concatString = '';
    
    public function getStringValue() {
        $values = $this->calculateValues();
        return implode($this->concatString, $values);
    }

    public function calculateValues() {
        $result = [];

        foreach ($this->valuesIterator as $value) {
            $result[] = $this->applyRules(new Value($value))->getValue();
        }

        return $result;
    }

    public function setConcatString(String $string) {
        $this->concatString = $string;
    }
    
    public function setValues(\Traversable $iterator) {
        $this->valuesIterator = $iterator;
    }
    
    public function addRule(RuleInterface $rule, ValueInterface $value) {
        $this->ruleTuples[] = [$rule, $value];
        return $this;
    }

    private function applyRules(ValueInterface $value): ValueInterface {
        foreach ($this->ruleTuples as $ruleTuple) {
            if (! $ruleTuple[0]->apply($value)) {
                continue;
            }
                
            $translation = clone $ruleTuple[1];
            $translation->setValue($value);
            $value = $translation;
        }

        return $value;
    }
}