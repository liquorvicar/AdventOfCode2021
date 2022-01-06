<?php

namespace AdventOfCode\Day21;

class DeterministicDie
{
    private $nextRoll = 1;
    private int $timesRolled = 0;

    /**
     * @param int $nextRoll
     */
    public function __construct(int $nextRoll)
    {
        $this->nextRoll = $nextRoll;
    }

    public function roll(): int
    {
        $thisRoll = $this->nextRoll;
        $this->nextRoll++;
        if ($this->nextRoll > 100) {
            $this->nextRoll = 1;
        }
        $this->timesRolled++;
        return $thisRoll;
    }

    public function timesRolled()
    {
        return $this->timesRolled;
    }
}