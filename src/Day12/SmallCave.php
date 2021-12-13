<?php

namespace AdventOfCode\Day12;

class SmallCave extends Cave
{

    public function isSmallCave()
    {
        return true;
    }

    public function getExits($canVisitTwice)
    {
        if ($canVisitTwice) {
            return $this->exits;
        }
        return !$this->visited ? $this->exits : [];
    }
}