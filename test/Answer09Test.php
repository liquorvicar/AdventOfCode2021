<?php

namespace AdventOfCode;

class Answer09Test extends BaseTest
{
    /**
     * @var Answer09
     */
    protected $answer;

    public function setUp(): void
    {
        parent::setUp();
        $this->answer = new Answer09($this->logger);
    }

    public function testFindLowestPoints() {
        $input = [
            [2, 1, 9, 9, 9, 4, 3, 2, 1, 0, ],
            [3, 9, 8, 7, 8, 9, 4, 9, 2, 1, ],
            [9, 8, 5, 6, 7, 8, 9, 8, 9, 2, ],
            [8, 7, 6, 7, 8, 9, 6, 7, 8, 9, ],
            [9, 8, 9, 9, 9, 6, 5, 6, 7, 8, ],
        ];
        $expected = [0,1,5,5,];
        $this->assertEquals($expected, $this->answer->findHeightOfLowestPoints($input));
    }

    public function testOne()
    {
        $input = [
            '2199943210',
            '3987894921',
            '9856789892',
            '8767896789',
            '9899965678'
        ];
        $this->assertEquals(15, $this->answer->one($input));
    }

    /**
     * @param $row
     * @param $col
     * @param $size
     * @dataProvider dataForFindBasinSize
     */
    public function testFindBasinSize($row, $col, $size)
    {
        $grid = [
            [2, 1, 9, 9, 9, 4, 3, 2, 1, 0, ],
            [3, 9, 8, 7, 8, 9, 4, 9, 2, 1, ],
            [9, 8, 5, 6, 7, 8, 9, 8, 9, 2, ],
            [8, 7, 6, 7, 8, 9, 6, 7, 8, 9, ],
            [9, 8, 9, 9, 9, 6, 5, 6, 7, 8, ],
        ];
        $this->assertEquals($size, $this->answer->findBasinSize($grid, $row, $col));
    }

    public function dataForFindBasinSize()
    {
        return [
            [0, 1, 3],
            [0, 9, 9],
            [2, 2, 14],
            [4, 6, 9],
        ];
    }

    public function testTwo()
    {
        $input = [
            '2199943210',
            '3987894921',
            '9856789892',
            '8767896789',
            '9899965678'
        ];
        $this->assertEquals(1134, $this->answer->two($input));

    }
}
