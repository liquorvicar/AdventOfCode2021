<?php

namespace AdventOfCode\Day12;

use AdventOfCode\BaseTest;

class SmallCaveTest extends BaseTest
{

    public function testIsSmallCave()
    {
        $cave = Cave::fromName('a');
        $this->assertInstanceOf('AdventOfCode\Day12\SmallCave', $cave);
    }

    public function testGetExitsWithNoVisits()
    {
        $cave = new SmallCave('a');
        $cave->addExit('b');
        $cave->addExit('c');
        $this->assertEquals(['b', 'c'], $cave->getExits(false));
    }

    public function testGetExitsNoExitsLeftAfterVisit()
    {
        $cave = new SmallCave('a');
        $cave->addExit('b');
        $cave->addExit('c');
        $cave->visit();
        $this->assertEquals([], $cave->getExits(false));
    }
}