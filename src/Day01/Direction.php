<?php

namespace AdventOfCode\Day01;

class Direction implements Moveable
{

    private string $direction;
    private int $distance;

    public function __construct(string $instruction)
    {
        $parts = explode(' ', $instruction);
        $this->direction = trim($parts[0]);
        $this->distance = (int)trim($parts[1]);
    }

    public function move(Position $currentPosition): Position
    {
        $horizontal = $currentPosition->horizontal();
        $depth = $currentPosition->depth();
        switch ($this->direction) {
            case 'forward':
                $horizontal+= $this->distance;
                break;
            case 'down':
                $depth+= $this->distance;
                break;
            case 'up':
                $depth-= $this->distance;
                break;
        }
        return new Position($horizontal, $depth);
    }
}