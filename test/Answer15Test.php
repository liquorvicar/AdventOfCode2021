<?php

namespace AdventOfCode;

class Answer15Test extends BaseTest
{
    /**
     * @var Answer15
     */
    protected $answer;

    public function setUp(): void
    {
        parent::setUp();
        $this->answer = new Answer15($this->logger);
    }

    public function testOne()
    {
        $input = [
            '1163751742',
            '1381373672',
            '2136511328',
            '3694931569',
            '7463417111',
            '1319128137',
            '1359912421',
            '3125421639',
            '1293138521',
            '2311944581',
        ];
        $this->assertEquals(40, $this->answer->one($input));
    }

    public function testTwo()
    {
        $input = [
            '1163751742',
            '1381373672',
            '2136511328',
            '3694931569',
            '7463417111',
            '1319128137',
            '1359912421',
            '3125421639',
            '1293138521',
            '2311944581',
        ];
        $this->assertEquals(315, $this->answer->two($input));
    }
}
