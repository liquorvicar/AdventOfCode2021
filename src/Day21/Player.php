<?php

namespace AdventOfCode\Day21;

class Player
{
    private int $id;
    private int $position;
    private int $score = 0;

    /**
     * @param int $id
     * @param int $position
     */
    public function __construct(int $id, int $position)
    {
        $this->id = $id;
        $this->position = $position;
    }

    public function takeTurn(DeterministicDie $die)
    {
        $move = 0;
        $move+= $die->roll();
        $move+= $die->roll();
        $move+= $die->roll();
        $this->position = ($this->position + $move) % 10;
        if ($this->position === 0) {
            $this->position = 10;
        }
        $this->score+= $this->position;
    }

    public function getScore()
    {
        return $this->score;
    }

    public function getPosition()
    {
        return $this->position;
    }
}