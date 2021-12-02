<?php

namespace AdventOfCode\Day01;

class Position
{

    private int $horizontal;
    private int $depth;
    private int $aim;

    public function __construct(int $horizontal, int $depth, int $aim = 0)
    {

        $this->horizontal = $horizontal;
        $this->depth = $depth;
        $this->aim = $aim;
    }

    public function horizontal(): int
    {
        return $this->horizontal;
    }

    public function depth(): int
    {
        return $this->depth;
    }

    public function aim(): int
    {
        return $this->aim;
    }

    public function move(Moveable $direction): Position
    {
        return $direction->move($this);
    }
}