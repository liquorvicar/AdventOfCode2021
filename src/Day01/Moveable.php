<?php

namespace AdventOfCode\Day01;

interface Moveable
{
    public function move(Position $currentPosition): Position;
}
