<?php
namespace WhizzBang\Tests\Integration;

use PHPUnit\Framework\TestCase;
use \WhizzBang\Value;
use \WhizzBang\CompositeTranslation;
use \WhizzBang\ConstantTranslation;
use \WhizzBang\IdentityTranslation;
use \WhizzBang\Rule;
use \WhizzBang\WhizzBang;

class WhizzBangTest extends TestCase{
    private $whizzBangValue;
    private $whizzBang;
    
    public function setUp() {
        $whizzEntries = [];
        for($i = 1; $i <= 100; $i++){
            $res = '';
            if (($i % 3) === 0) {
                $res .= 'Whizz';
            }

            if (($i % 5) === 0) {
                $res .= 'Bang';
            }

            $whizzEntries[] = ($res !== '' ? $res : $i);
        }

        $this->whizzBangValues = implode(' ', $whizzEntries);

        $this->whizzBang = new WhizzBang();
        $this->whizzBang->setValues(new \ArrayIterator(array_keys(array_fill(1, 100, null))));
        $this->whizzBang->setConcatString(' ');
    }

    public function testFirstWhizz() {
        $whizzTranslation = new ConstantTranslation('Whizz');
        $bangTranslation = new ConstantTranslation('Bang');
        $whizzBangTranslation = new CompositeTranslation($whizzTranslation, $bangTranslation);

        $this->whizzBang
            ->addRule(Rule::modOriginal(3), $whizzTranslation)
            ->addRule(Rule::modOriginal(5), $bangTranslation)
            ->addRule(
                Rule::andRule(
                    Rule::modOriginal(3),
                    Rule::modOriginal(5)), $whizzBangTranslation);

        
        $this->assertSame($this->whizzBangValues, $this->whizzBang->getStringValue());
    }

    public function testSecondWhizz() {
        $whizzTranslation = new ConstantTranslation('Whizz');
        $bangTranslation = new ConstantTranslation('Bang');
        $prependWhizzTranslation = new CompositeTranslation($whizzTranslation, new IdentityTranslation());
        
        $this->whizzBang
            ->addRule(Rule::modOriginal(3), $whizzTranslation)
            ->addRule(Rule::modOriginal(5), $bangTranslation)
            ->addRule(
                Rule::andRule(
                    Rule::matchRule('Bang'),
                    Rule::modOriginal(3)), $prependWhizzTranslation);
        $this->assertSame($this->whizzBangValues, $this->whizzBang->getStringValue());
    }

    public function testThirdWhizz() {
        $whizzTranslation = new ConstantTranslation('Whizz');
        $bangTranslation = new ConstantTranslation('Bang');
        $appendBangTranslation = new CompositeTranslation(new IdentityTranslation(), $bangTranslation);
        $this->whizzBang
            ->addRule(Rule::modOriginal(3), $whizzTranslation)
            ->addRule(
                Rule::andRule(
                    Rule::notRule(
                        Rule::modOriginal(3)),
                    Rule::modOriginal(5)), $bangTranslation)
            ->addRule(Rule::andRule(Rule::matchRule('Whizz'), Rule::modOriginal(5)), $appendBangTranslation);
        $this->assertSame($this->whizzBangValues, $this->whizzBang->getStringValue());
    }
}
