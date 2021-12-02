<?php

namespace AdventOfCode;

use AdventOfCode\Day01\Direction;
use AdventOfCode\Day01\DirectionAim;
use AdventOfCode\Day01\Position;

class Answer02 extends Base {

    public function one(array $input)
    {
        $position = new Position(0, 0);
        foreach ($input as $instruction) {
            $position = $position->move(new Direction($instruction));
        }

        return $position->horizontal() * $position->depth();
    }

    public function two(array $input)
    {
        $position = new Position(0, 0);
        foreach ($input as $instruction) {
            $position = $position->move(new DirectionAim($instruction));
        }

        return $position->horizontal() * $position->depth();
    }
}

