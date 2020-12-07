<?php

namespace AOC\AdventOfCode2020\Day4;

use AOC\AdventOfCode2020\Utils\AOCCommand;

class Day4 extends AOCCommand
{
    protected static $defaultName = 'aoc:2020:day4';
    protected string $inputPath = __DIR__ . '/input';

    private const PASSPORT_SEPARATOR = PHP_EOL . PHP_EOL;

    private function getPassports(string $input): array
    {
        $passports = explode(self::PASSPORT_SEPARATOR, $input);
        $passports = array_map(function ($line) {
            $all = [];
            preg_match_all('/(\w+):([^\s]+)/', trim($line), $all);

            $passport = [];
            foreach ($all[1] as $key => $value) {
                $passport[$value] = $all[2][$key];
            }

            return $passport;
        }, $passports);

        return $passports;
    }

    protected function executeInput(string $input): void
    {
        $passports = $this->getPassports($input);

        $requiredRule = new Rule(fn ($value) => true);
        $rulesetPart1 = new Ruleset([
            'byr' => $requiredRule,
            'iyr' => $requiredRule,
            'eyr' => $requiredRule,
            'hgt' => $requiredRule,
            'hcl' => $requiredRule,
            'ecl' => $requiredRule,
            'pid' => $requiredRule,
        ]);
        $countPart1 = $rulesetPart1->validate($passports);
        $this->output->writeln("- part 1: $countPart1");

        $rulesetPart2 = new Ruleset();
        $rulesetPart2->add('byr', new Rule(fn($value) => is_numeric($value) && (int)$value >= 1920 && (int)$value <= 2002));
        $rulesetPart2->add('iyr', new Rule(fn($value) => is_numeric($value) && (int)$value >= 2010 && (int)$value <= 2020));
        $rulesetPart2->add('eyr', new Rule(fn($value) => is_numeric($value) && (int)$value >= 2020 && (int)$value <= 2030));
        $rulesetPart2->add('hgt', new Rule(function ($value) {
            $matches = [];
            if (!preg_match('/^(\d+)(in|cm)$/', $value, $matches)) {
                return false;
            }

            [,$height, $unit] = $matches;
            return match ($unit) {
                'cm' => (int)$height >= 150 && (int)$height <= 193,
                'in' => (int)$height >= 59 && (int)$height <= 76,
                default => false
            };
        }));
        $rulesetPart2->add('hcl', new Rule(fn ($value) => preg_match('/^#([0-9a-f]{6})$/', $value) === 1));
        $rulesetPart2->add('ecl', new Rule(fn ($value) => match ($value) {'amb', 'blu', 'brn', 'gry', 'grn', 'hzl', 'oth' => true, default => false}));
        $rulesetPart2->add('pid', new Rule(fn ($value) => preg_match('/^\d{9}$/', $value) === 1));
        $countPart2 = $rulesetPart2->validate($passports);
        $this->output->writeln("- part 2: $countPart2");
    }
}
