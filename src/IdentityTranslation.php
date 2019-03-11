<?php
namespace WhizzBang;

class IdentityTranslation extends AbstractTranslation {
    public function getValue() {
        return $this->value->getValue();
    }
}
