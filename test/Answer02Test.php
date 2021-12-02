<?php

namespace AdventOfCode;


use AdventOfCode\Day01\Direction;
use AdventOfCode\Day01\DirectionAim;
use AdventOfCode\Day01\Position;

class Answer02Test extends BaseTest
{

    /**
     * @param $direction
     * @param $horizontal
     * @param $depth
     * @dataProvider dataForSingleDirection
     */
    public function testSingleDirection($direction, $horizontal, $depth) {
        $position = new Position(0, 0);
        $finalPosition = $position->move($direction);
        $this->assertEquals($horizontal, $finalPosition->horizontal());
        $this->assertEquals($depth, $finalPosition->depth());
    }

    public function dataForSingleDirection()
    {
        return [
            [new Direction('forward 5'), 5, 0],
            [new Direction('down 5'), 0, 5],
            [new Direction('up 5'), 0, -5],
        ];
    }

    public function testPartOne()
    {
        $input = [
            'forward 5',
            'down 5',
            'forward 8',
            'up 3',
            'down 8',
            'forward 2',
        ];
        $answer = new Answer02($this->logger);
        $this->assertEquals(150, $answer->one($input));
    }
    /**
     * @dataProvider dataForSingleAimDirection
     */
    public function testSingleAimDirection(DirectionAim $direction, Position $position, int $horizontal, int $depth, int $aim) {
        $finalPosition = $position->move($direction);
        $this->assertEquals($horizontal, $finalPosition->horizontal());
        $this->assertEquals($depth, $finalPosition->depth());
        $this->assertEquals($aim, $finalPosition->aim());
    }

    public function dataForSingleAimDirection()
    {
        return [
            [new DirectionAim('forward 5'),new Position(0, 0), 5, 0, 0],
            [new DirectionAim('down 5'), new Position(0, 0), 0, 0, 5],
            [new DirectionAim('up 5'), new Position(0, 0), 0, 0, -5],
            [new DirectionAim('forward 8'), new Position(5, 0, 5), 13, 40, 5],
        ];
    }

    public function testPartTwo()
    {
        $input = [
            'forward 5',
            'down 5',
            'forward 8',
            'up 3',
            'down 8',
            'forward 2',
        ];
        $answer = new Answer02($this->logger);
        $this->assertEquals(900, $answer->two($input));
    }
}
