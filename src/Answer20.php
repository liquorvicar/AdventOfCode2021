<?php

namespace AdventOfCode;

class Answer20 extends Base
{

    public function one(array $input, $iterations = 2)
    {
        $algorithm = array_shift($input);
        $grid = array_filter($input);
        $grid = $this->parseGrid($grid);
        $default = '.';
        $flip = substr($algorithm, 0, 1) === '#';
        while ($iterations > 0) {
            $grid = $this->applyAlgorithm($grid, $algorithm, $default);
            if ($flip) {
                $default = $default === '.' ? '#' : '.';
            }
            $iterations--;
        }
        return array_reduce($grid, function ($count, $line) {
            return $count + array_reduce($line, function ($lineCount, $pixel) {
                if ($pixel === '#') {
                    $lineCount++;
                }
                return $lineCount;
                }, 0);
        }, 0);
    }

    public function two(array $input)
    {
        return $this->one($input, 50);
    }

    public function parseGrid(array $grid)
    {
        return array_map(function ($line) {
            return str_split($line);
        }, $grid);
    }

    public function getOutputIndex(array $grid, array $pixel, string $default = '.')
    {
        list($x, $y) = $pixel;
        $binary = '';
        $binary.= $this->getPixelStatus($grid, $x - 1, $y - 1, $default);
        $binary.= $this->getPixelStatus($grid, $x, $y - 1, $default);
        $binary.= $this->getPixelStatus($grid, $x + 1, $y - 1, $default);
        $binary.= $this->getPixelStatus($grid, $x - 1, $y, $default);
        $binary.= $this->getPixelStatus($grid, $x, $y, $default);
        $binary.= $this->getPixelStatus($grid, $x + 1, $y, $default);
        $binary.= $this->getPixelStatus($grid, $x - 1, $y + 1, $default);
        $binary.= $this->getPixelStatus($grid, $x, $y + 1, $default);
        $binary.= $this->getPixelStatus($grid, $x + 1, $y + 1, $default);
        return bindec($binary);
    }

    private function getPixelStatus(array $grid, mixed $x, mixed $y, string $default = '.')
    {
        if (!isset($grid[$y])) {
            return $default === '#' ? '1' : '0';
        }
        if (!isset($grid[$y][$x])) {
            return $default === '#' ? '1' : '0';
        }
        return $grid[$y][$x] === '#' ? '1' : '0';
    }

    public function getMappedPixel(array $grid, string $algorithm, array $pixel, string $default = '.')
    {
        $index = $this->getOutputIndex($grid, $pixel, $default);
        return substr($algorithm, $index, 1);
    }

    public function applyAlgorithm(array $grid, string $algorithm, string $default = '.')
    {
        $minX = null;
        $maxX = null;
        $minY = null;
        $maxY = null;
        foreach ($grid as $y => $line) {
            foreach ($line as $x => $pixel) {
                if ($pixel === '#') {
                    if (is_null($minX)) {
                        $minX = $x;
                    } elseif ($x < $minX) {
                        $minX = $x;
                    }
                    if (is_null($minY)) {
                        $minY = $y;
                    } elseif ($y < $minY) {
                        $minY = $y;
                    }
                    if (is_null($maxX)) {
                        $maxX = $x;
                    } elseif ($x > $maxX) {
                        $maxX = $x;
                    }
                    if (is_null($maxY)) {
                        $maxY = $y;
                    } elseif ($y > $maxY) {
                        $maxY = $y;
                    }
                }
            }
        }
        $newGrid = [];
        for ($x = ($minX - 2); $x <= ($maxX + 2); $x++) {
            for ($y = ($minY - 2); $y <= ($maxY + 2); $y++) {
                if (!isset($newGrid[$y][$x])) {
                    $newGrid[$y][$x] = $default;
                }
                $newGrid[$y][$x] = $this->getMappedPixel($grid, $algorithm, [$x, $y], $default);
            }
        }
        return $newGrid;
    }
}

