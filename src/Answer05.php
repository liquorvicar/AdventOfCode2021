<?php

namespace AdventOfCode;

use AdventOfCode\Day05\Line;
use AdventOfCode\Day05\Point;

class Answer05 extends Base
{

    public function one(array $input)
    {
        $lines = $this->getLines($input);
        $points = $this->getPoints($lines, true);
        return $this->countMultiples($points);
    }

    public function two(array $input)
    {
        $lines = $this->getLines($input);
        $points = $this->getPoints($lines, false);
        return $this->countMultiples($points);
    }

    private function getLines($input)
    {
        $lines = [];
        foreach ($input as $inputLine) {
            if (empty($inputLine)) {
                continue;
            }
            $lines[] = Line::fromString($inputLine);
        }
        $this->logger->debug('Found lines', ['count' => count($lines)]);
        return $lines;
    }

    private function getPoints($lines, $excludeDiagonals)
    {
        $points = [];
        foreach ($lines as $line) {
            if ($excludeDiagonals && !$line->isStraight()) {
                continue;
            }
            foreach ($line->getPoints() as $point) {
                $points[$point->getKey()][] = $line;
            }
        }
        $this->logger->debug('Found points', ['count' => count($points)]);
        return $points;
    }

    private function countMultiples($points)
    {
        return array_reduce($points, function ($multiples, $point) {
            if (count($point) > 1) {
                $multiples++;
            }
            return $multiples;
        }, 0);
    }
}

