<?php
namespace WhizzBang;

abstract class AbstractTranslation implements TranslationInterface{
    protected $value = null;

    public function setValue(ValueInterface $value) {
        $this->value = $value;
    }

    public function getOriginalObject() {
        if (! isset($this->value)) {
            throw new \Exception('No original object set');
        }

        return $this->value->getOriginalObject();
    }

    public function __clone() {
        $this->value = null;
    }
}