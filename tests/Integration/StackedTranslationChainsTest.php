<?php
namespace WhizzBang\Tests\Integration;

use PHPUnit\Framework\TestCase;
use \WhizzBang\Value;
use \WhizzBang\CompositeTranslation;
use \WhizzBang\ConstantTranslation;
use \WhizzBang\IdentityTranslation;
use \WhizzBang\Rule;

class StackedTranslationChainsTest extends TestCase{
    public function testNestedCompositeTranslations() {
        
        $chain1 = $this->getChain();
        $chain2 = $this->getChain();
        $chain3 = $this->getChain();
        $chain4 = $this->getChain();

        $chain1->setValue(new Value('val'));
        $chain2->setValue($chain1);
        $chain3->setValue($chain2);
        $chain4->setValue($chain3);
        
        $this->assertSame('((((val))))', $chain4->getValue());
    }

    public function testRulesAgainstNestedTranslations() {
        $chain1 = $this->getChain();
        $chain2 = $this->getChain();
        $chain3 = $this->getChain();
        
        $chain1->setValue(new Value('13'));
        $chain2->setValue($chain1);
        $chain3->setValue($chain2);

        $this->assertTrue(Rule::matchRule('(((13)))')->apply($chain3));
        $this->assertTrue(Rule::modOriginal(13)->apply($chain3));
    }

    private function getChain() {
        $one = new ConstantTranslation('(');
        $two = new IdentityTranslation();
        $three = new ConstantTranslation(')');

        return new CompositeTranslation($one, $two, $three);
    }
}

