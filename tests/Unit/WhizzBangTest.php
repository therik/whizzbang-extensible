<?php
namespace WhizzBang\Tests\Unit;

use PHPUnit\Framework\TestCase;
use \WhizzBang\WhizzBang;


class WhizzBangTest extends TestCase{
    public function testWhizzBangInstantiates() {
        $this->assertInstanceOf(WhizzBang::class, new WhizzBang());
    }

    public function testEmptyBang() {
        $SUT = new WhizzBang();
        $SUT->setValues(new \ArrayIterator([1, 2, 3, 4, 5]));
        
        $this->assertSame([1, 2, 3, 4, 5], $SUT->calculateValues());
    }

    public function testConcatString() {
        $SUT = new WhizzBang();
        $SUT->setValues(new \ArrayIterator(['one', 'two', 'three', 'four']));
        $SUT->setConcatString(' and ');

        $this->assertSame('one and two and three and four', $SUT->getStringValue());
    }
}