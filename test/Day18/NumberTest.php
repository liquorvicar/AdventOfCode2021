<?php

namespace AdventOfCode\Day18;

use AdventOfCode\BaseTest;

class NumberTest extends BaseTest
{

    /**
     * @param $number
     * @param $newNumber
     * @dataProvider dataForExplodeActions
     */
    public function testExplodeActions($number, $newNumber)
    {
        $number = new Number($number);
        $result = $number->runAction();
        $this->assertInstanceOf('AdventOfCode\Day18\Number', $result);
        $this->assertEquals($newNumber, $result->toString());
    }

    public function dataForExplodeActions()
    {
        return [
            ['[[[[[9,8],1],2],3],4]', '[[[[0,9],2],3],4]'],
            ['[7,[6,[5,[4,[3,2]]]]]', '[7,[6,[5,[7,0]]]]'],
            ['[[6,[5,[4,[3,2]]]],1]', '[[6,[5,[7,0]]],3]'],
            ['[[3,[2,[1,[7,3]]]],[6,[5,[4,[3,2]]]]]', '[[3,[2,[8,0]]],[9,[5,[4,[3,2]]]]]'],
            ['[[3,[2,[8,0]]],[9,[5,[4,[3,2]]]]]', '[[3,[2,[8,0]]],[9,[5,[7,0]]]]'],
            ['[[[[0,7],4],[7,[[8,4],9]]],[1,1]]', '[[[[0,7],4],[15,[0,13]]],[1,1]]'],
            ['[[[[0,7],4],[[7,8],[0,[6,7]]]],[1,1]]', '[[[[0,7],4],[[7,8],[6,0]]],[8,1]]'],
            ['[[[[12,12],[6,14]],[[15,0],[17,[8,1]]]],[2,9]]', '[[[[12,12],[6,14]],[[15,0],[25,0]]],[3,9]]']
        ];
    }

    public function testSplitNumber()
    {
        $number = new Number('[[[[0,7],4],[15,[0,13]]],[1,1]]');
        $newNumber = $number->runAction();
        $this->assertEquals('[[[[0,7],4],[[7,8],[0,13]]],[1,1]]', $newNumber->toString());
    }

    /**
     * @param $number
     * @param $magnitude
     * @dataProvider dataForMagnitude
     */
    public function testCalculateMagnitude($number, $magnitude)
    {
        $number = new Number($number);
        $this->assertEquals($magnitude, $number->calculateMagnitude());
    }

    public function dataForMagnitude()
    {
        return [
            ['[9,1]', 29],
            ['[1,9]', 21],
            ['[[9,1],[1,9]]', 129],
            ['[[1,2],[[3,4],5]]', 143],
            ['[[[[0,7],4],[[7,8],[6,0]]],[8,1]]', 1384],
            ['[[[[1,1],[2,2]],[3,3]],[4,4]]', 445],
            ['[[[[3,0],[5,3]],[4,4]],[5,5]]', 791],
            ['[[[[5,0],[7,4]],[5,5]],[6,6]]', 1137],
            ['[[[[8,7],[7,7]],[[8,6],[7,7]]],[[[0,7],[6,6]],[8,7]]]', 3488],
        ];
    }
}