<?php

namespace AOC\AdventOfCode2020\Day4;

class Ruleset
{
    private array $ruleset;

    public function __construct(array $ruleset = [])
    {
        foreach ($ruleset as $field => $rule) {
            $this->add($field, $rule);
        }
    }

    public function add(string $field, Rule $rule)
    {
        $this->ruleset[$field] = $rule;
    }

    public function validate(array $passports)
    {
        $validationCount = 0;

        /** @var Rule $rule */
        foreach ($passports as $passport) {
            $valid = true;
            foreach ($this->ruleset as $field => $rule) {
                if (!isset($passport[$field])) {
                    $valid = false;
                    break;
                }

                $valid &= $rule->validate($passport[$field]);
            }

            $validationCount += $valid ? 1 : 0;
        }

        return $validationCount;
    }
}