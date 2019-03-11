<?php
namespace WhizzBang\Tests\Integration;

use PHPUnit\Framework\TestCase;
use \WhizzBang\Value;
use \WhizzBang\CompositeTranslation;
use \WhizzBang\ConstantTranslation;
use \WhizzBang\IdentityTranslation;

class CompositeTranslationTest extends TestCase{
    public function testNestedCompositeTranslations() {
        $one = new ConstantTranslation('one ');
        $two = new ConstantTranslation('two ');
        $three = new IdentityTranslation();
        $four = new ConstantTranslation('four ');

        $com1 = new CompositeTranslation($one, $two);
        $com2 = new CompositeTranslation($three, $four);

        $comTop = new CompositeTranslation($com1, $com2);

        $value = new Value('val ');
        
        $comTop->setValue($value);

        $this->assertSame('one two val four ', $comTop->getValue());
    }
    
    public function testPrependAppend() {
        $value = new Value('val');
        $pre = new ConstantTranslation('pre-');
        $id = new IdentityTranslation();
        $post = new ConstantTranslation('-post');

        $SUT = new CompositeTranslation($pre, $id, $post);

        $SUT->setValue($value);

        $this->assertSame('pre-val-post', $SUT->getValue());
    }
    
    public function testClonesParents() {
        $tr1 = new ConstantTranslation('one');
        $tr2 = new ConstantTranslation('two');

        $translation = new CompositeTranslation($tr1, $tr2);

        $firstValue = new Value('value1');
        $secondValue = new Value('value2');

        $translation->setValue($firstValue);

        $clone = clone $translation;

        $clone->setValue($secondValue);

        $this->assertNotSame($translation->getOriginalObject(), $clone->getOriginalObject());
        $this->assertSame($firstValue, $translation->getOriginalObject());
        $this->assertSame($secondValue, $clone->getOriginalObject());

        $this->assertSame($firstValue, $tr1->getOriginalObject()); // check that the first parent's value is untouched
    }
}

