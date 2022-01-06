<?php

namespace AdventOfCode\Day21;

use PHPUnit\Framework\TestCase;

class DeterministicDieTest extends TestCase
{

    public function testRollGetsNextNumberInSequence()
    {
        $die = new DeterministicDie(1);
        $this->assertEquals(1, $die->roll());
        $this->assertEquals(2, $die->roll());
    }

    public function testRollLoopsBackAt100()
    {
        $die = new DeterministicDie(100);
        $die->roll();
        $this->assertEquals(1, $die->roll());
    }

    public function testCountRolls()
    {
        $die = new DeterministicDie(100);
        $die->roll();
        $die->roll();
        $die->roll();
        $die->roll();
        $this->assertEquals(4, $die->timesRolled());

    }
}
