<?php

namespace AdventOfCode;

class Answer09 extends Base
{

    public function one(array $input)
    {
        $grid = array_map(function ($line) {
            $row = str_split($line);
            return array_map(function ($value) {
                return (int)$value;
            }, $row);
        }, $input);
        $lowestPoints = $this->findHeightOfLowestPoints($grid);
        $lowestPoints = array_map(function ($value) {
            return ++$value;
        }, $lowestPoints);
        return array_sum($lowestPoints);
    }

    public function two(array $input)
    {
        $grid = array_map(function ($line) {
            $row = str_split($line);
            return array_map(function ($value) {
                return (int)$value;
            }, $row);
        }, $input);
        $lowestPoints = $this->findLowestPoints($grid);
        $basins = [];
        foreach ($lowestPoints as $lowestPoint) {
            $basins[] = $this->findBasinSize($grid, $lowestPoint[0], $lowestPoint[1]);
        }
        rsort($basins);
        return $basins[0] * $basins[1] * $basins[2];
    }

    public function findLowestPoints(array $input)
    {
        $lowestPoints = [];
        foreach ($input as $row => $line) {
            foreach ($line as $col => $point) {
                $isLowPoint = true;
                if ($this->isLowerThan($point, $input, $row, $col + 1)) {
                    $isLowPoint = false;
                }
                if ($this->isLowerThan($point, $input, $row, $col - 1)) {
                    $isLowPoint = false;
                }
                if ($this->isLowerThan($point, $input, $row + 1, $col)) {
                    $isLowPoint = false;
                }
                if ($this->isLowerThan($point, $input, $row - 1, $col)) {
                    $isLowPoint = false;
                }
                if ($isLowPoint) {
                    $lowestPoints[] = [$row, $col];
                }
            }
        }
        return $lowestPoints;
    }

    private function isLowerThan($point, $input, $row, $col) {
        return isset($input[$row][$col]) && $input[$row][$col] <= $point;
    }

    public function findHeightOfLowestPoints(array $input)
    {
        $lowestPoints = $this->findLowestPoints($input);
        $heights = array_map(function ($coords) use ($input) {
            return $input[$coords[0]][$coords[1]];
        }, $lowestPoints);
        sort($heights);
        return $heights;
    }

    public function findBasinSize(array $grid, $row, $col)
    {
        $basin = $this->findBasin($grid, $row, $col, []);
        return count($basin);
    }

    private function findBasin(array $grid, $row, $col, array $basin)
    {
        if (in_array("$row-$col", $basin)) {
            return $basin;
        }
        $basin[] = "$row-$col";
        $point = $grid[$row][$col];
        if ($this->isPartOfBasin($point, $grid, $row, $col + 1)) {
            $basin = $this->findBasin($grid, $row, $col + 1, $basin);
        }
        if ($this->isPartOfBasin($point, $grid, $row, $col - 1)) {
            $basin = $this->findBasin($grid, $row, $col - 1, $basin);
        }
        if ($this->isPartOfBasin($point, $grid, $row + 1, $col)) {
            $basin = $this->findBasin($grid, $row + 1, $col, $basin);
        }
        if ($this->isPartOfBasin($point, $grid,$row - 1, $col)) {
            $basin = $this->findBasin($grid, $row - 1, $col, $basin);
        }
        return $basin;
    }

    private function isPartOfBasin($point, $input, $row, $col) {
        if (!isset($input[$row][$col])) {
            return false;
        }
        $thisPoint = $input[$row][$col];
        if ($thisPoint === 9) {
            return false;
        }
        return $thisPoint >= $point;
    }
}

