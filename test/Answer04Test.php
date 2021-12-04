<?php

namespace AdventOfCode;


class Answer04Test extends BaseTest
{
    /**
     * @var Answer04
     */
    protected $answer;

    public function setUp(): void
    {
        parent::setUp();
        $this->answer = new Answer04($this->logger);
    }

    public function testMarkNumberCalled()
    {
        $board = [
            22, 13, 17, 11,  0,
             8,  2, 23,  4, 24,
            21,  9, 14, 16,  7,
             6, 10,  3, 18,  5,
             1, 12, 20, 15, 19,
        ];
        $numberCalled = 7;
        $newBoard = $this->answer->markNumberCalled($board, $numberCalled);
        $this->assertNull($newBoard[14]);
    }

    /**
     * @param $board
     * @param $isWinner
     * @dataProvider dataForCheckWinner
     */
    public function testCheckWinner($board, $isWinner)
    {
        $result = $this->answer->checkWinner($board);
        $this->assertEquals($isWinner, $result);
    }

    public function dataForCheckWinner()
    {
        return [
            [[22, 13, 17, 11,  0, 8,  2, 23,  4, 24, 21,  9, 14, 16,  7, 6, 10,  3, 18,  5, 1, 12, 20, 15, 19,], false],
            [[null, null, null, null,  0, 8,  2, 23,  4, 24, 21,  9, 14, 16,  7, 6, 10,  3, 18,  5, 1, 12, 20, 15, 19,], false],
            [[null, 13, 17, 11,  0, null,  2, 23,  4, 24, null,  9, 14, 16,  7, 6, 10,  3, 18,  5, null, 12, 20, 15, 19,], false],
            [[22, null, 17, 11,  0, 8,  2, null,  4, 24, 21,  9, 14, null,  7, 6, 10,  3, 18,  null, 1, 12, 20, 15, false,], false],
            [[22, 13, 17, 11,  0, null, null, null, null, null, 21,  9, 14, 16,  7, 6, 10,  3, 18,  5, 1, 12, 20, 15, 19,], true],
            [[22, null, 17, 11,  0, 8,  null, 23,  4, 24, 21,  null, 14, 16,  7, 6, null,  3, 18,  5, 1, null, 20, 15, 19,], true],
        ];
    }

    public function testTwo()
    {
        $input = [
            '7,4,9,5,11,17,23,2,0,14,21,24,10,16,13,6,15,25,12,22,18,20,8,19,3,26,1',
            '',
            '22 13 17 11  0',
            ' 8  2 23  4 24',
            '21  9 14 16  7',
            ' 6 10  3 18  5',
            ' 1 12 20 15 19',
            '',
            '3 15  0  2 22',
            '9 18 13 17  5',
            '19  8  7 25 23',
            '20 11 10 24  4',
            '14 21 16 12  6',
            '',
            '14 21 17 24  4',
            '10 16 15  9 19',
            '18  8 23 26 20',
            '22 11 13  6  5',
            '2  0 12  3  7',
        ];
        $answer = $this->answer->two($input);

        $this->assertEquals(1924, $answer);
    }
}
