<?php

namespace AdventOfCode;

class Answer07 extends Base
{

    public function one(array $input)
    {
        $crabs = array_map(function ($value) {
            return (int)$value;
        }, explode(',', $input[0]));
        return $this->findLeastFuel($crabs, false);
    }

    public function two(array $input)
    {
        $crabs = array_map(function ($value) {
            return (int)$value;
        }, explode(',', $input[0]));
        return $this->findLeastFuel($crabs, true);
    }

    private function findLeastFuel($crabs, $useFibonacci)
    {
        sort($crabs);
        $min = $crabs[0];
        rsort($crabs);
        $max = $crabs[0];
        $leastFuel = false;
        for ($pos = $min; $pos <= $max; $pos++) {
            if ($useFibonacci) {
                $fuels = array_map(function ($crab) use ($pos) {
                    $fuel = 0;
                    $steps = abs($pos - $crab);
                    while ($steps > 0) {
                        $fuel+= $steps;
                        $steps--;
                    }
                    return $fuel;
                }, $crabs);
            } else {
                $fuels = array_map(function ($crab) use ($pos) {
                    return abs($pos - $crab);
                }, $crabs);
            }
            $totalFuel = array_sum($fuels);
            if ($leastFuel === false || $leastFuel > $totalFuel) {
                $leastFuel = $totalFuel;
            }
        }
        return $leastFuel;
    }
}

