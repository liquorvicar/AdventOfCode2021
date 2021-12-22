<?php

namespace AdventOfCode;

class Answer15 extends Base
{

    public function one(array $input)
    {
        $maxX = strlen($input[0]) - 1;
        $maxY = count($input) -1;
        $nodes = [];
        foreach ($input as $y => $row) {
            foreach (str_split($row) as $x => $risk) {
                $nodes["$x-$y"] = ['node' => [$x,$y], 'risk' => (int)$risk, 'visited' => false, 'tentative' => PHP_INT_MAX];
            }
        }
        return $this->findLowestRisk($nodes, $maxX, $maxY);
    }

    public function two(array $input)
    {
        $maxX = strlen($input[0]) - 1;
        $maxY = count($input) -1;
        $nodes = [];
        foreach ($input as $y => $row) {
            foreach (str_split($row) as $x => $risk) {
                for ($repeatX = 0; $repeatX <= 4; $repeatX++) {
                    for ($repeatY = 0; $repeatY <= 4; $repeatY++) {
                        $trueX = $x + ($maxX + 1) * $repeatX;
                        $trueY = $y + ($maxY + 1) * $repeatY;
                        $trueRisk = (int)$risk + $repeatX + $repeatY;
                        if ($trueRisk > 9) {
                            $trueRisk-= 9;
                        }
                        $nodes["$trueX-$trueY"] = ['node' => [$trueX,$trueY], 'risk' => $trueRisk, 'visited' => false, 'tentative' => PHP_INT_MAX];
                    }
                }
            }
        }
        $maxX = (($maxX + 1) * 5) - 1;
        $maxY = (($maxY + 1) * 5) - 1;
        return $this->findLowestRisk($nodes, $maxX, $maxY);
    }

    private function findLowestRisk($nodes, $maxX, $maxY)
    {
        $possibles = ["0-0" => 0];
        $current = [0, 0];
        $nextNode = "0-0";
        $found = false;
        while (!$found) {
            $currentNode = "$current[0]-$current[1]";
            $possibles = $this->calculateTentative($current[0] + 1, $current[1], $nodes, $possibles, $currentNode);
            $possibles = $this->calculateTentative($current[0] - 1, $current[1], $nodes, $possibles, $currentNode);
            $possibles = $this->calculateTentative($current[0], $current[1] + 1, $nodes, $possibles, $currentNode);
            $possibles = $this->calculateTentative($current[0], $current[1] - 1, $nodes, $possibles, $currentNode);
            unset($possibles[$currentNode]);
            $nodes[$currentNode]['visited'] = true;
            asort($possibles);
            $nextNode = key($possibles);
            if ($nextNode === "$maxX-$maxY") {
                $found = true;
            }
            $current = explode('-', $nextNode);
            $this->logger->debug('Unvisited nodes', ['count' => count($possibles)]);
        }
        return $possibles[$nextNode];
    }

    private function calculateTentative(int $x, int $y, array $input, array $possibles, string $current)
    {
        if (!isset($input["$x-$y"]) || $input["$x-$y"]['visited']) {
            return $possibles;
        }
        $currentTentative = ($possibles["$x-$y"] ?? PHP_INT_MAX);
        $newTentative = $possibles[$current] + $input["$x-$y"]['risk'];
        if ($newTentative < $currentTentative) {
            $possibles["$x-$y"] = $newTentative;
        }
        return $possibles;
    }
}

