<?php
namespace WhizzBang\Tests\Integration;

use PHPUnit\Framework\TestCase;
use \WhizzBang\RuleInterface;
use \WhizzBang\AndRule;
use \WhizzBang\Rule;
use \WhizzBang\Value;
use \WhizzBang\ConstantTranslation;


class AndRuleTest extends TestCase{

    public function values() {
        return [
            [15, 5, 'sweet', 'sweet', true],
            [15, 5, 'sweet', 'not matched', false],
            [15, 4, 'sweet', 'sweet', false],
            [15, 4, 'sauer', 'bitter', false],
            
        ];
    }
    
    /**
     * @dataProvider values
     */
    public function testPossibilities($modValue, $modMatch, $translationValue, $match, $result) {
        $value = new Value($modValue);
        
        $rule1 = Rule::modOriginal($modMatch);
        $rule2 = Rule::matchRule($match);

        $andRule = Rule::andRule($rule1, $rule2);
        
        $translation = new ConstantTranslation($translationValue);
        $translation->setValue($value);

        $this->assertEquals($result, $andRule->apply($translation));
    }
}