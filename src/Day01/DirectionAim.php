<?php

namespace AdventOfCode\Day01;

class DirectionAim implements Moveable
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
        $aim = $currentPosition->aim();
        switch ($this->direction) {
            case 'forward':
                $horizontal+= $this->distance;
                $depth+= ($aim * $this->distance);
                break;
            case 'down':
                $aim+= $this->distance;
                break;
            case 'up':
                $aim-= $this->distance;
                break;
        }
        return new Position($horizontal, $depth, $aim);
    }
}