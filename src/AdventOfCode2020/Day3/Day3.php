<?php

namespace AOC\AdventOfCode2020\Day3;

use AOC\AdventOfCode2020\Utils\AOCCommand;

class Day3 extends AOCCommand
{
    protected static $defaultName = 'aoc:2020:day3';
    protected string $inputPath = __DIR__ . '/input';

    private function crossCalculation(string $input, Coordinates $move): int
    {
        $trees = explode(PHP_EOL, $input);
        $offset = strlen($trees[0]);
        $maxLines = count($trees);

        $position = new Coordinates(0, 0, $offset);

        $encounter = 0;
        while ($position->getY() < $maxLines) {
            $position->add($move);
            if (
                isset($trees[$position->getY()])
                && $trees[$position->getY()][$position->getX()] === '#'
            ) {
                $encounter++;
            }
        }

        return $encounter;
    }

    private function getOffset(string $input): int
    {
        return strlen(explode(PHP_EOL, $input)[0]);
    }

    /**
     * @param string $input
     * @param array[Coordinates] $coordinates
     */
    private function executeInputOnCoordinates(string $input, array $coordinates): void
    {
        $finalValue = 1;
        foreach ($coordinates as $coordinate) {
            $value = $this->crossCalculation($input, $coordinate);
            $finalValue *= $value;
            $this->output->writeln("value for ({$coordinate->getX()}, {$coordinate->getY()}): $value");
        }
        $this->output->writeln("final value for part2: $finalValue");
    }

    protected function executeInput(string $input): void
    {
        $offset = $this->getOffset($input);

        $this->output->writeln("- part 1:");
        $this->executeInputOnCoordinates($input, [new Coordinates(3, 1, $offset)]);

        $this->output->writeln("- part 2:");
        $this->executeInputOnCoordinates($input, [
            new Coordinates(1, 1, $offset),
            new Coordinates(5, 1, $offset),
            new Coordinates(7, 1, $offset),
            new Coordinates(3, 1, $offset),
            new Coordinates(1, 2, $offset),
        ]);
    }
}
