<?php
namespace WhizzBang;

class Rule {
    public static function andRule(RuleInterface... $rules): AndRule {
        return new AndRule(...$rules);
    }

    public static function modOriginal(int $value): ModOriginalRule {
        return new ModOriginalRule($value);
    }

    public static function matchRule($value): MatchRule {
        return new MatchRule($value);
    }

    public static function notRule($value): NotRule {
        return new NotRule($value);
    }
}