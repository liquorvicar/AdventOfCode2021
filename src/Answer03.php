<?php

namespace AdventOfCode;

class Answer03 extends Base
{

    public function one(array $input)
    {
        $gamma = $this->findGamma(array_filter($input));
        $epsilon = $this->findEpsilon($gamma);
        return bindec($gamma) * bindec($epsilon);
    }

    public function two(array $input)
    {
        $oxyGenRating = $this->findOxygenGeneratorRating($input);
        $co2ScrubRating = $this->findCO2ScrubberRating($input);
        return bindec($oxyGenRating) * bindec($co2ScrubRating);
    }

    public function findGamma(array $input)
    {
        $gamma = '';
        for ($i = 0; $i < strlen($input[0]); $i++) {
            $digits = array_map(function ($entry) use ($i) {
                return (int)$entry[$i];
            }, $input);
            $sum = array_sum($digits);
            if ($sum > (count($input)/2)) {
                $gamma.= '1';
            } else {
                $gamma.= '0';
            }
        }

        return $gamma;
    }

    public function findEpsilon(string $gamma)
    {
        $epsilon = '';
        foreach (str_split($gamma) as $digit) {
            if ($digit === '1') {
                $epsilon.= '0';
            } else {
                $epsilon.= '1';
            }
        }
        return $epsilon;
    }

    public function findOxygenGeneratorRating(array $input)
    {
        $filter = function ($input, $pos) {
            $digits = array_map(function ($entry) use ($pos) {
                return (int)$entry[$pos];
            }, $input);
            $sum = array_sum($digits);
            if ($sum >= (count($input)/2)) {
                return '1';
            } else {
                return '0';
            }
        };
        return $this->findValue($input, $filter, 0);
    }

    private function findValue(array $input, \Closure $filter, int $pos)
    {
        if (count($input) === 1) {
            return array_pop($input);
        }
        $checkDigit = $filter($input, $pos);
        $newInput = array_filter($input, function ($value) use ($checkDigit, $pos) {
            return $value[$pos] === $checkDigit;
        });
        return $this->findValue($newInput, $filter, ($pos+1));
    }

    public function findCO2ScrubberRating(array $input)
    {
        $filter = function ($input, $pos) {
            $digits = array_map(function ($entry) use ($pos) {
                return (int)$entry[$pos];
            }, $input);
            $sum = array_sum($digits);
            if ($sum >= (count($input)/2)) {
                return '0';
            } else {
                return '1';
            }
        };
        return $this->findValue($input, $filter, 0);
    }
}

