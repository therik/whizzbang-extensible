<?php
namespace WhizzBang\Tests\Unit;

use PHPUnit\Framework\TestCase;
use \WhizzBang\RuleInterface;
use \WhizzBang\AndRule;
use \WhizzBang\Rule;
use \WhizzBang\ValueInterface;


class AndRuleTest extends TestCase{
    public function testAndRuleInstantiates() {
        $rule1 = $this->createMock(RuleInterface::class);
        $rule2 = $this->createMock(RuleInterface::class);

        $this->assertInstanceOf(AndRule::class, new AndRule($rule1, $rule2));
        $this->assertInstanceOf(AndRule::class, Rule::andRule($rule1, $rule2));
    }

    public function andTruthTables() {
        return [
            [false, false, false],
            [false, true, false],
            [true, false, false],
            [true, true, true],
        ];
    }

    /**
     * @dataProvider andTruthTables
     */
    public function testAndRuleTruthTables($a, $b, $result) {
        $value = $this->createMock(ValueInterface::class);

        $rule1 = $this->createMock(RuleInterface::class);
        $rule1->expects($this->once())
              ->method('apply')
              ->with($this->identicalTo($value))
              ->willReturn($a);

        $rule2 = $this->createMock(RuleInterface::class);

        $secondExpectedTimes = $a ? $this->once() : $this->never();
        
        $rule2->expects($secondExpectedTimes)
              ->method('apply')
              ->with($this->identicalTo($value))
              ->willReturn($b);

        $SUT = Rule::andRule($rule1, $rule2);

        $this->assertEquals($result, $SUT->apply($value));
    }
}