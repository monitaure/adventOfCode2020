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

        $rulesPart1 = [
            'byr' => fn() => true,
            'iyr' => fn() => true,
            'eyr' => fn() => true,
            'hgt' => fn() => true,
            'hcl' => fn() => true,
            'ecl' => fn() => true,
            'pid' => fn() => true,
        ];
        $countPart1 = $this->validatePassports($passports, $rulesPart1);
        $this->output->writeln("- part 1: $countPart1");
    }

    private function validatePassports(array $passports, array $rules): int
    {
        $validationCount = 0;
        foreach ($passports as $passport) {
            $validationCount += $this->validatePassport($passport, $rules) ? 1 : 0;
        }
        return $validationCount;
    }

    private function validatePassport(array $passport, array $rules): bool
    {
        $valid = true;
        foreach ($rules as $rule => $validate) {
            if (!isset($passport[$rule])) {
                $valid = false;
                continue;
            }

            $validation = $validate($passport[$rule]);

            if ($validation === false) {
                $valid = false;
            }
        }

        return $valid;
    }
}
