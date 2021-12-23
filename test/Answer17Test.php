<?php

namespace AdventOfCode;

class Answer17Test extends BaseTest
{
    /**
     * @var Answer17
     */
    protected $answer;

    public function setUp(): void
    {
        parent::setUp();
        $this->answer = new Answer17($this->logger);
    }

    public function testParseInput()
    {
        $expected = [
            'x' => [265, 287,],
            'y' => [-58, -103,],
        ];
        $this->assertEquals($expected, $this->answer->parseInput(['target area: x=265..287, y=-103..-58']));
    }

    public function testOne()
    {
        $this->assertEquals(45, $this->answer->one(['target area: x=20..30, y=-10..-5']));
    }

    public function testTwo()
    {
        $this->assertEquals(112, $this->answer->two(['target area: x=20..30, y=-10..-5']));
    }
}
