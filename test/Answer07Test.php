<?php

namespace AdventOfCode;

class Answer07Test extends BaseTest
{
    /**
     * @var Answer07
     */
    protected $answer;

    public function setUp(): void
    {
        parent::setUp();
        $this->answer = new Answer07($this->logger);
    }

    public function testOne()
    {
        $input = [
            '16,1,2,0,4,2,7,1,2,14',
        ];
        $this->assertEquals(37, $this->answer->one($input));
    }

    public function testTwo()
    {
        $input = [
            '16,1,2,0,4,2,7,1,2,14',
        ];
        $this->assertEquals(168, $this->answer->two($input));
    }
}
