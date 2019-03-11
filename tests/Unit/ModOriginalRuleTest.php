<?php
namespace WhizzBang\Tests\Unit;

use PHPUnit\Framework\TestCase;
use \WhizzBang\RuleInterface;
use \WhizzBang\ModOriginalRule;
use \WhizzBang\Rule;
use \WhizzBang\ValueInterface;


class ModOriginalRuleTest extends TestCase{
    public function testAndRuleInstantiates() {
        $this->assertInstanceOf(ModOriginalRule::class, new ModOriginalRule(12));
        $this->assertInstanceOf(ModOriginalRule::class, Rule::modOriginal(12));
    }

    public function testModOriginal() {
        $value = $this->createMock(ValueInterface::class);
        $value->method('getOriginalObject')->willReturn($value);
        $value->method('getValue')->willReturn(14);

        $this->assertTrue(Rule::modOriginal(7)->apply($value));
        $this->assertFalse(Rule::modOriginal(9)->apply($value));
    }
}