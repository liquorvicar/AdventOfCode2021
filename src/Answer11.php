<?php

namespace AdventOfCode;

class Answer11 extends Base
{

    public function one(array $input)
    {
        $grid = array_map(function ($row) {
            return array_map(function ($energy) {
                return (int)$energy;
            }, str_split($row));
        }, $input);
        $result = ['grid' => $grid];
        $flashes = 0;
        for ($i = 0; $i < 100; $i++) {
            $result = $this->processStep($result['grid']);
            $flashes+= count($result['flashes']);
        }
        return $flashes;
    }

    public function two(array $input)
    {
        $grid = array_map(function ($row) {
            return array_map(function ($energy) {
                return (int)$energy;
            }, str_split($row));
        }, $input);
        $result = ['grid' => $grid];
        $notAllFlashed = true;
        $step = 1;
        while ($notAllFlashed) {
            $result = $this->processStep($result['grid']);
            if (count($result['flashes']) === 100) {
                return $step;
            }
            $step++;
        }
    }

    public function processStep(array $input)
    {
        $hasFlashed = [];
        $flashHappened = true;
        $grid = [];
        foreach ($input as $row => $line) {
            foreach ($line as $col => $energy) {
                $grid[$row][$col] = ($energy + 1);
            }
        }
        $gridSize = count($grid);
        while ($flashHappened) {
            $row = 0;
            $col = 0;
            $flashHappened = false;
            while ($row < $gridSize) {
                if ($grid[$row][$col] > 9 && !in_array("$row-$col", $hasFlashed)) {
                    $grid = $this->octopusFlash($grid, $row, $col);
                    $hasFlashed[] = "$row-$col";
                    $flashHappened = true;
                }
                $col++;
                if ($col >= $gridSize) {
                    $col = 0;
                    $row++;
                }
            }
        }
        $finalGrid = [];
        foreach ($grid as $row => $line) {
            foreach ($line as $col => $energy) {
                $finalGrid[$row][$col] = $energy > 9 ? 0 : $energy;
            }
        }
        return ['flashes' => $hasFlashed, 'grid' => $finalGrid];
    }

    private function octopusFlash(array $grid, int $row, int $col)
    {
        if (isset($grid[$row-1][$col-1])) {
            $grid[$row-1][$col-1]++;
        }
        if (isset($grid[$row-1][$col])) {
            $grid[$row-1][$col]++;
        }
        if (isset($grid[$row-1][$col+1])) {
            $grid[$row-1][$col+1]++;
        }
        if (isset($grid[$row][$col+1])) {
            $grid[$row][$col+1]++;
        }
        if (isset($grid[$row+1][$col+1])) {
            $grid[$row+1][$col+1]++;
        }
        if (isset($grid[$row+1][$col])) {
            $grid[$row+1][$col]++;
        }
        if (isset($grid[$row+1][$col-1])) {
            $grid[$row+1][$col-1]++;
        }
        if (isset($grid[$row][$col-1])) {
            $grid[$row][$col-1]++;
        }
        return $grid;
    }
}

