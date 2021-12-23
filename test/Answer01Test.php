<?php

namespace AdventOfCode;

use Monolog\Logger;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class Answer01Test extends BaseTest
{
    public function testCountIncreases() {
        $answer = new Answer01($this->logger);
        $input = [
            199,
            200,
            208,
            210,
            200,
            207,
            240,
            269,
            260,
            263,
        ];
        $this->assertEquals(7, $answer->countIncreases($input));
    }

    public function testCountIncreasesInWindows() {
        $answer = new Answer01($this->logger);
        $input = [
            199,
            200,
            208,
            210,
            200,
            207,
            240,
            269,
            260,
            263,
        ];
        $this->assertEquals(5, $answer->countIncreasesInWindows($input));
    }
}

