<?php

namespace AdventOfCode;


class Answer03Test extends BaseTest
{
    /**
     * @var Answer03
     */
    protected $answer;

    public function setUp(): void
    {
        parent::setUp();
        $this->answer = new Answer03($this->logger);
    }

    public function testFindGammaRate()
    {
        $input = [
            '00100',
            '11110',
            '10110',
            '10111',
            '10101',
            '01111',
            '00111',
            '11100',
            '10000',
            '11001',
            '00010',
            '01010',
        ];
        $this->assertEquals('10110', $this->answer->findGamma($input));
    }

    public function testFindEpsilon()
    {
        $this->assertEquals('01001', $this->answer->findEpsilon('10110'));
    }

    public function testOne()
    {
        $input = [
            '00100',
            '11110',
            '10110',
            '10111',
            '10101',
            '01111',
            '00111',
            '11100',
            '10000',
            '11001',
            '00010',
            '01010',
        ];
        $this->assertEquals(198, $this->answer->one($input));
    }

    public function testTwo()
    {
        $input = [
            '00100',
            '11110',
            '10110',
            '10111',
            '10101',
            '01111',
            '00111',
            '11100',
            '10000',
            '11001',
            '00010',
            '01010',
        ];
        $this->assertEquals(230, $this->answer->two($input));
    }

    public function testFindOxygenGeneratorRating()
    {
        $input = [
            '00100',
            '11110',
            '10110',
            '10111',
            '10101',
            '01111',
            '00111',
            '11100',
            '10000',
            '11001',
            '00010',
            '01010',
        ];
        $this->assertEquals('10111', $this->answer->findOxygenGeneratorRating($input));
    }

    public function testFindCO2ScrubberRating()
    {
        $input = [
            '00100',
            '11110',
            '10110',
            '10111',
            '10101',
            '01111',
            '00111',
            '11100',
            '10000',
            '11001',
            '00010',
            '01010',
        ];
        $this->assertEquals('01010', $this->answer->findCO2ScrubberRating($input));
    }
}