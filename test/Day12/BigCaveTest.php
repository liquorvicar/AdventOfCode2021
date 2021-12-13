<?php

namespace AdventOfCode\Day12;

use AdventOfCode\BaseTest;

class BigCaveTest extends BaseTest
{
    public function testIsBigCave()
    {
        $cave = Cave::fromName('ABC');
        $this->assertInstanceOf('AdventOfCode\Day12\BigCave', $cave);
    }

    public function testGetExitsWithNoVisits()
    {
        $cave = new BigCave('AB');
        $cave->addExit('b');
        $cave->addExit('c');
        $this->assertEquals(['b', 'c'], $cave->getExits());
    }

    public function testGetExitsOnSecondVisit()
    {
        $cave = new BigCave('AB');
        $cave->addExit('b');
        $cave->addExit('c');
        $cave->visit();
        $cave->useExit('b');
        $this->assertEquals(['c'], $cave->getExits());
    }
}