<?php

namespace AdventOfCode;

class Answer21Test extends BaseTest
{
    /**
     * @var Answer21
     */
    protected $answer;

    public function setUp(): void
    {
        parent::setUp();
        $this->answer = new Answer21($this->logger);
    }

    public function testParseInput()
    {
        $input = ['Player 1 starting position: 7', 'Player 2 starting position: 6'];
        $this->assertEquals([7, 6], $this->answer->getStartingPositions($input));
    }

    public function testPlayGame()
    {
        $input = ['Player 1 starting position: 4', 'Player 2 starting position: 8'];
        $this->assertEquals(739785, $this->answer->one($input));
    }

    public function testTwo()
    {
        $input = ['Player 1 starting position: 4', 'Player 2 starting position: 8'];
        $this->assertEquals(444356092776315, $this->answer->two($input));
    }
}
