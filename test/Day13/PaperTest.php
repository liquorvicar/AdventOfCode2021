<?php

namespace AdventOfCode\Day13;

use AdventOfCode\BaseTest;

class PaperTest extends BaseTest
{

    public function testFoldY()
    {
        $paper = new Paper([
            [6,10],
            [0,14],
            [9,10],
            [0,3],
            [10,4],
            [4,11],
            [6,0],
            [6,12],
            [4,1],
            [0,13],
            [10,12],
            [3,4],
            [3,0],
            [8,4],
            [1,10],
            [2,14],
            [8,10],
            [9,0],
        ]);
        $newPaper = $paper->fold('y', 7);
        $newDots = [
            [0, 0],
            [2, 0],
            [3, 0],
            [6, 0],
            [9, 0],
            [0, 1],
            [4, 1],
            [6, 2],
            [10, 2],
            [0, 3],
            [4, 3],
            [1, 4],
            [3, 4],
            [6, 4],
            [8, 4],
            [9, 4],
            [10, 4],
        ];
        $this->assertEquals($newDots, $newPaper->dots());
    }

    public function testFoldX()
    {
        $paper = new Paper([
            [0, 0],
            [2, 0],
            [3, 0],
            [6, 0],
            [9, 0],
            [0, 1],
            [4, 1],
            [6, 2],
            [10, 2],
            [0, 3],
            [4, 3],
            [1, 4],
            [3, 4],
            [6, 4],
            [8, 4],
            [9, 4],
            [10, 4],
        ]);
        $newPaper = $paper->fold('x', 5);
        $newDots = [
            [0, 0],
            [1, 0],
            [2, 0],
            [3, 0],
            [4, 0],
            [0, 1],
            [4, 1],
            [0, 2],
            [4, 2],
            [0, 3],
            [4, 3],
            [0, 4],
            [1, 4],
            [2, 4],
            [3, 4],
            [4, 4],
        ];
        $this->assertEquals($newDots, $newPaper->dots());
    }
}