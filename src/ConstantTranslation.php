<?php
namespace WhizzBang;

class ConstantTranslation extends AbstractTranslation{
    private $translationValue;
    
    public function __construct($translationValue) {
        $this->translationValue = $translationValue;
    }

    public function getValue(){
        return $this->translationValue;
    }
}