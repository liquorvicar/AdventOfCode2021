<?php

namespace AdventOfCode\Day21;

use PHPUnit\Framework\TestCase;

class PlayerTest extends TestCase
{

    /**
     * @dataProvider dataForTakeTurn
     */
    public function testTakeTurn($id, $startPos, $nextRoll, $position)
    {
        $player = new Player($id, $startPos);
        $die = new DeterministicDie($nextRoll);
        $player->takeTurn($die);
        $this->assertEquals($position, $player->getPosition());
    }

    public function dataForTakeTurn()
    {
        return [
            [1, 4, 1, 10,],
            [2, 8, 4, 3,],
            [1, 10, 7, 4,],
            [2, 3, 10, 6,],
        ];
    }
}
