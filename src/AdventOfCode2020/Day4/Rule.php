<?php

namespace AOC\AdventOfCode2020\Day4;

class Rule
{
    private $rule;

    public function __construct(callable $rule)
    {
        $this->rule = $rule;
    }

    public function validate($value): bool
    {
        return ($this->rule)($value);
    }
}