<?php

namespace AdventOfCode;

class Answer12Test extends BaseTest
{
    /**
     * @var Answer12
     */
    protected $answer;

    public function setUp(): void
    {
        parent::setUp();
        $this->answer = new Answer12($this->logger);
    }

    /**
     * @param $caves
     * @param $count
     * @dataProvider dataForOne
     */
    public function testOne($caves, $count) {
        $result = $this->answer->one($caves);
        $this->assertEquals($count, $result);
    }

    public function dataForOne()
    {
        return [
            [['start-A', 'start-b', 'A-c', 'A-b', 'b-d', 'A-end', 'b-end'], 10],
            [['dc-end', 'HN-start', 'start-kj', 'dc-start', 'dc-HN', 'LN-dc', 'HN-end', 'kj-sa', 'kj-HN', 'kj-dc'], 19]
        ];
    }

    /**
     * @param $caves
     * @param $count
     * @dataProvider dataForTwo
     */
    public function testTwo($caves, $count) {
        $result = $this->answer->two($caves);
        $this->assertEquals($count, $result);
    }

    public function dataForTwo()
    {
        return [
            [['start-A', 'start-b', 'A-c', 'A-b', 'b-d', 'A-end', 'b-end'], 36],
            [['dc-end', 'HN-start', 'start-kj', 'dc-start', 'dc-HN', 'LN-dc', 'HN-end', 'kj-sa', 'kj-HN', 'kj-dc'], 103]
        ];
    }
}
