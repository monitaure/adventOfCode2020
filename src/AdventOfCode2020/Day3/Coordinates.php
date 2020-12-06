<?php

namespace AOC\AdventOfCode2020\Day3;

class Coordinates
{
    public function __construct(
        public int $x,
        public int $y,
        public int $offset = 0
    ) {}

    public function add(Coordinates $add)
    {
        $this->x = ($this->x + $add->x) % $this->offset;
        $this->y += $add->y;
    }

    /**
     * @return int
     */
    public function getX(): int
    {
        return $this->x;
    }

    /**
     * @return int
     */
    public function getY(): int
    {
        return $this->y;
    }
}
