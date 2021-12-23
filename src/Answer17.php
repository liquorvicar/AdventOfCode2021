<?php

namespace AdventOfCode;

class Answer17 extends Base
{

    public function one(array $input)
    {
        $target = $this->parseInput($input);
        $this->logger->debug('Probing for target', ['target' => $target]);
        $max = 0;
        for ($x = 1; $x <= $target['x'][1]; $x++) {
            for ($y = $target['y'][1]; $y < ($target['y'][1] * -1); $y++) {
                if ($x === 23 && $y === 102) {
                    $this->logger->debug('Found highest', ['highest' => $highest]);
                }
                $highest = $this->launchProbe([$x, $y], $target);
                if (!is_null($highest) && $highest > $max) {
                    $max = $highest;
                }
            }
        }
        return $max;
    }

    public function two(array $input)
    {
        $target = $this->parseInput($input);
        $this->logger->debug('Probing for target', ['target' => $target]);
        $hit = 0;
        for ($x = 1; $x <= $target['x'][1]; $x++) {
            for ($y = $target['y'][1]; $y < ($target['y'][1] * -1); $y++) {
                $highest = $this->launchProbe([$x, $y], $target);
                if (!is_null($highest)) {
                    $hit++;
                }
            }
        }
        return $hit;
    }

    private function launchProbe($velocity, $target)
    {
        $position = [0, 0];
        list($x, $y) = $velocity;
        $missed = false;
        $hit = false;
        $highest = 0;
        while (!$missed && !$hit) {
            $position = [$position[0] + $x, $position[1] + $y];
            $x = $x > 0 ? $x - 1 : ($x < 0 ? $x + 1 : 0);
            $y-= 1;
            if ($position[1] > $highest) {
                $highest = $position[1];
            }
            if ($x === 0 && $position[0] < $target['x'][0]) {
                $missed = true;
            } elseif ($position[1] < $target['y'][1]) {
                $missed = true;
            } elseif ($target['x'][0] <= $position[0] && $position[0] <= $target['x'][1]
                && $target['y'][1] <= $position[1] && $position[1] <= $target['y'][0]) {
                $hit = true;
            } elseif ($position[0] > $target['x'][1]) {
                $missed = true;
            }
        }
        return $hit ? $highest : null;
    }

    public function parseInput(array $input)
    {
        $target = [
            'x' => [],
            'y' => [],
        ];
        $matches = [];
        preg_match('/target area: x=([-0-9]+)..([-0-9]+), y=([-0-9]+)..([-0-9]+)/', $input[0], $matches);
        $target['x'] = [(int)$matches[1], (int)$matches[2]];
        $target['y'] = [(int)$matches[4], (int)$matches[3]];
        return $target;
    }
}

