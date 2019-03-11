<?php
namespace WhizzBang;

require_once('vendor/autoload.php');

$whizzTranslation = new ConstantTranslation('Whizz');
$bangTranslation = new ConstantTranslation('Bang');


$whizzBang = new WhizzBang();

/**
 * Option one: most straight forward, mod3 becomes "whizz", mod5 becomes "bang", mod3 && mod5 becomes "WhizzBang". Later constant translations overwrite previous ones, so only WhizzBang from the last rule stays.
 */
$whizzBangTranslation = new CompositeTranslation($whizzTranslation, $bangTranslation);
$whizzBang
    ->addRule(Rule::modOriginal(3), $whizzTranslation)
    ->addRule(Rule::modOriginal(5), $bangTranslation)
    ->addRule(
        Rule::andRule(
            Rule::modOriginal(3),
            Rule::modOriginal(5)), $whizzBangTranslation);


/**
 * Option two: The third rule uses the fact that mod3 && mod5 gets first translated to whizz, then to bang. Third rule's matcher will match on a value that's already been translated to Bang, && the original value that is (x mod 3=0). 
 * For example: the third rule matcher will see number 10 as "Bang", but it won't be divisible by 3, so it won't match. 
 * Or: the third matcher will see number 15 as "Bang", and the original value (15) is divisible by 3, so it will match and the translation will happen
 * The translation in this case is different, it will PREPEND to the value that's been set by previous rules. 
 * IdentityTranslation just passes on the same value on, ConstantTranslation changes the value to a constant string and CompositeTranslation concatenates the two
 *
 */
/* $prependWhizzTranslation = new CompositeTranslation($whizzTranslation, new IdentityTranslation()); */
/* $whizzBang */
/*     ->addRule(Rule::modOriginal(3), $whizzTranslation) */
/*     ->addRule(Rule::modOriginal(5), $bangTranslation) */
/*     ->addRule( */
/*         Rule::andRule( */
/*             Rule::matchRule('Bang'), */
/*             Rule::modOriginal(3)), $prependWhizzTranslation); */


/**
 * Option three: first rule matches any mod3, second rule matches mod5 but not mod3, third rule matches on current value being "Whizz" && the original value being divisible by 3
 *
 * The third rule's translation here also appends to previous value, but "Bang" to "Whiz" in this case, so we get back to WhizzBuzz again.
 */
/* $appendBangTranslation = new CompositeTranslation(new IdentityTranslation(), $bangTranslation); */
/* $whizzBang */
/*     ->addRule(Rule::modOriginal(3), $whizzTranslation) */
/*     ->addRule( */
/*         Rule::andRule( */
/*             Rule::notRule( */
/*                 Rule::modOriginal(3)), */
/*             Rule::modOriginal(5)), $bangTranslation) */
/*     ->addRule(Rule::andRule(Rule::matchRule('Whizz'), Rule::modOriginal(5)), $appendBangTranslation); */



$generator = function () {
    for($i = 1; $i <= 100; $i++){
        yield $i;
    }
};

$whizzBang->setValues($generator());
$whizzBang->setConcatString("\n");

echo $whizzBang->getStringValue();
