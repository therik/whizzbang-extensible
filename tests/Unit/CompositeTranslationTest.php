<?php
namespace WhizzBang\Tests\Unit;

use PHPUnit\Framework\TestCase;
use \WhizzBang\AbstractTranslation;
use \WhizzBang\ValueInterface;
use \WhizzBang\CompositeTranslation;
use \WhizzBang\TranslationInterface;
use \WhizzBang\ConstantTranslation;


class CompositeTranslationTest extends TestCase{
    public function testAndRuleInstantiates() {
        $this->assertInstanceOf(CompositeTranslation::class, new CompositeTranslation());
    }

    public function testTranslatesValue() {
        $value = $this->createMock(ValueInterface::class);
        $value->method('getValue')->willReturn('wrong value');
        
        
        $tr1 = $this->getTranslationMock('Hello');
        $tr2 = $this->getTranslationMock(' ');
        $tr3 = $this->getTranslationMock('World');

        
        $SUT = new CompositeTranslation($tr1, $tr2, $tr3);
        $SUT->setValue($value);

        $this->assertSame('Hello World', $SUT->getValue());
    }

    public function testSetsValueOfParents() {
        $value = $this->createMock(ValueInterface::class);
        $value->method('getValue')->willReturn('wrong value');
        
        $tr1 = $this->getTranslationMock('first');
        $tr2 = $this->getTranslationMock('second');

        $tr1->expects($this->once())
            ->method('setValue')
            ->with($this->identicalTo($value));

        $tr2->expects($this->once())
            ->method('setValue')
            ->with($this->identicalTo($value));

        $SUT = new CompositeTranslation($tr1, $tr2);
        $SUT->setValue($value);
    }

    private function getTranslationMock($value) {
        $translationMock = $this->createMock(TranslationInterface::class);
        $translationMock->method('getValue')->willReturn($value);
        return $translationMock;
    }
}