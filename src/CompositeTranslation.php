<?php
namespace WhizzBang;

class CompositeTranslation extends AbstractTranslation{
    private $parents = [];

    public function __construct(TranslationInterface... $parents) {
        $this->parents = $parents;
    }

    public function getValue(){
        if (empty($this->parents)) {
            return $this->value;
        }
        
        $result = '';

        foreach ($this->parents as $parent) {
            $result .= $parent->getValue();
        }

        return $result;
    }

    public function setValue(ValueInterface $value) {
        $this->value = $value;

        foreach ($this->parents as $parent) {
            $parent->setValue($value);
        }
    }

    public function __clone() {
        $this->value = null;
        $newParents = [];
        foreach ($this->parents as $parent) {
            $newParents[] = clone $parent;
        }

        $this->parents = $newParents;
    }
}