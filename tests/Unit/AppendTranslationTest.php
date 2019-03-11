<?php
namespace WhizzBang\Tests\Unit;

use PHPUnit\Framework\TestCase;
use \WhizzBang\ValueInterface;
use \WhizzBang\IdentityTranslation;


class IdentityTranslationTest extends TestCase{
    public function testInstantiates() {
        $this->assertInstanceOf(IdentityTranslation::class, new IdentityTranslation());
    }

    public function testTranslatesValue() {
        $value = $this->createMock(ValueInterface::class);
        $value->method('getValue')->willReturn('value');

        $SUT = new IdentityTranslation();

        $SUT->setValue($value);
        $this->assertSame('value', $SUT->getValue());
    }
}