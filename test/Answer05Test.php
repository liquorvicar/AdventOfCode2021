<?php

namespace AdventOfCode;

use AdventOfCode\Day05\Line;
use AdventOfCode\Day05\Point;

class Answer05Test extends BaseTest
{
    /**
     * @var Answer05
     */
    protected $answer;

    public function setUp(): void
    {
        parent::setUp();
        $this->answer = new Answer05($this->logger);
    }

    public function testProcessInputLine()
    {
        $input = '936,971 -> 267,302';
        $line = Line::fromString($input);
        $this->assertInstanceOf('\AdventOfCode\Day05\Line', $line);
        $this->assertEquals(new Point(936, 971), $line->getEnd());
        $this->assertEquals(new Point(267, 302), $line->getStart());
        $this->assertEquals(false, $line->isStraight());
    }

    public function testOne()
    {
        $input = [
            '0,9 -> 5,9',
            '8,0 -> 0,8',
            '9,4 -> 3,4',
            '2,2 -> 2,1',
            '7,0 -> 7,4',
            '6,4 -> 2,0',
            '0,9 -> 2,9',
            '3,4 -> 1,4',
            '0,0 -> 8,8',
            '5,5 -> 8,2',
        ];
        $this->assertEquals(5, $this->answer->one($input));
    }

    public function testTwo()
    {
        $input = [
            '0,9 -> 5,9',
            '8,0 -> 0,8',
            '9,4 -> 3,4',
            '2,2 -> 2,1',
            '7,0 -> 7,4',
            '6,4 -> 2,0',
            '0,9 -> 2,9',
            '3,4 -> 1,4',
            '0,0 -> 8,8',
            '5,5 -> 8,2',
        ];
        $this->assertEquals(12, $this->answer->two($input));
    }

    /**
     * @param $lineString
     * @param $count
     * @dataProvider dataForCountPoints
     */
    public function testCountPoints($lineString, $count)
    {
        $line = Line::fromString($lineString);
        $this->assertEquals($count, count($line->getPoints()));
    }

    public function dataForCountPoints()
    {
        return [
            ['0,9 -> 5,9', 6,],
            ['8,0 -> 0,8', 9,],
            ['9,4 -> 3,4', 7,],
            ['2,2 -> 2,1', 2,],
            ['7,0 -> 7,4', 5,],
            ['6,4 -> 2,0', 5,],
            ['0,9 -> 2,9', 3,],
            ['3,4 -> 1,4', 3,],
            ['0,0 -> 8,8', 9,],
            ['5,5 -> 8,2', 4,],
        ];
    }
}
