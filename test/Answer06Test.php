<?php

namespace AdventOfCode;

class Answer06Test extends BaseTest
{
    /**
     * @var Answer06
     */
    protected $answer;

    public function setUp(): void
    {
        parent::setUp();
        $this->answer = new Answer06($this->logger);
    }

    public function testOneAfter18Days()
    {
        $fish = [3,4,3,1,2];
        $result = $this->answer->modelCycles($fish, 18);
        $this->assertEquals(26, $result);
    }

    public function testOneAfter80Days()
    {
        $fish = [3,4,3,1,2];
        $result = $this->answer->modelCycles($fish, 80);
        $this->assertEquals(5934, $result);
    }

    public function testOneAfter256Days()
    {
        $fish = [3,4,3,1,2];
        $result = $this->answer->modelCycles($fish, 256);
        $this->assertEquals(26984457539, $result);
    }
}
