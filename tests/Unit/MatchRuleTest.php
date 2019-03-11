<?php
namespace WhizzBang\Tests\Unit;

use PHPUnit\Framework\TestCase;
use \WhizzBang\RuleInterface;
use \WhizzBang\MatchRule;
use \WhizzBang\Rule;
use \WhizzBang\ValueInterface;


class MatchRuleTest extends TestCase{
    public function testAndRuleInstantiates() {
        $this->assertInstanceOf(MatchRule::class, new MatchRule('value'));
        $this->assertInstanceOf(MatchRule::class, Rule::MatchRule('value'));
    }

    public function testMatchesValue() {
        $value = $this->createMock(ValueInterface::class);
        $value->method('getValue')->willReturn('rightValue');
        
        $this->assertTrue((Rule::matchRule('rightValue'))->apply($value));
        $this->assertFalse((Rule::matchRule('----- wrong value ----'))->apply($value));
    }
}