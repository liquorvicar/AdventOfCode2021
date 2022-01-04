<?php

namespace AdventOfCode\Day19;

class Vector
{
    public $x;
    public $y;
    public $z;


    public function __construct(int $x, int $y, int $z)
    {
        $this->x = $x;
        $this->y = $y;
        $this->z = $z;
    }

    public function __toString(): string
    {
        return implode(':', [$this->x, $this->y, $this->z]);
    }

}
