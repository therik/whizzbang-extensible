<?php
namespace WhizzBang\Tests\Unit;

use PHPUnit\Framework\TestCase;
use \WhizzBang\RuleInterface;
use \WhizzBang\NotRule;
use \WhizzBang\Rule;
use \WhizzBang\ValueInterface;


class NotRuleTest extends TestCase{
    public function testAndRuleInstantiates() {
        $rule = $this->createMock(RuleInterface::class);
        
        $this->assertInstanceOf(NotRule::class, new NotRule($rule));
        $this->assertInstanceOf(NotRule::class, Rule::notRule($rule));
    }

    public function notTruthTables() {
        return [
            [true, false],
            [false, true],
        ];
    }

    /**
     * @dataProvider notTruthTables
     */
    public function testMatchesValue($val, $result) {
        $value = $this->createMock(ValueInterface::class);
        
        $rule = $this->createMock(RuleInterface::class);
        $rule->method('apply')
             ->with($this->identicalTo($value))
             ->willReturn($val);

        $this->assertSame($result, (Rule::notRule($rule))->apply($value));
    }
}