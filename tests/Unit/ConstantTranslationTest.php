<?php
namespace WhizzBang\Tests\Unit;

use PHPUnit\Framework\TestCase;
use \WhizzBang\AbstractTranslation;
use \WhizzBang\ValueInterface;
use \WhizzBang\ConstantTranslation;


class ConstantTranslationTest extends TestCase{
    public function testAndRuleInstantiates() {
        $this->assertInstanceOf(ConstantTranslation::class, new ConstantTranslation('transl'));
    }

    public function testTranslatesValue() {
        $value = $this->createMock(ValueInterface::class);
        $value->method('getValue')->willReturn('wrong value');
        
        $translation = new ConstantTranslation('translated value');
        $translation->setValue($value);

        $this->assertSame('translated value', $translation->getValue());
    }
}