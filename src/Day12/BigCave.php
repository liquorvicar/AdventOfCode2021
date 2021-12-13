<?php

namespace AdventOfCode\Day12;

class BigCave extends Cave
{

    public function isSmallCave()
    {
        return false;
    }

    public function getExits($canVisitTwice)
    {
        if ($canVisitTwice) {
            return $this->exits;
        }
        return array_values(array_diff($this->exits, $this->usedExits));
    }
}