<?php

namespace AdventOfCode\Day13;

class Paper
{
    private $dots;

    /**
     * @param \int[][] $array
     */
    public function __construct(array $dots)
    {
        $this->dots = $dots;
    }

    public function fold(string $plane, int $position): Paper
    {
        if ($plane === 'y') {
            $currentDots = array_filter($this->dots, function ($dot) use ($position) {
                return $dot[1] < $position;
            });
            $dotsToTranspose = array_filter($this->dots, function ($dot) use ($position) {
                return $dot[1] > $position;
            });
            $transposedDots = array_map(function ($dot) use ($position) {
                $y = $dot[1] - $position;
                $y = $position - $y;
                return [$dot[0], $y];
            }, $dotsToTranspose);
        } else {
            $currentDots = array_filter($this->dots, function ($dot) use ($position) {
                return $dot[0] < $position;
            });
            $dotsToTranspose = array_filter($this->dots, function ($dot) use ($position) {
                return $dot[0] > $position;
            });
            $transposedDots = array_map(function ($dot) use ($position) {
                $x = $dot[0] - $position;
                $x = $position - $x;
                return [$x, $dot[1]];
            }, $dotsToTranspose);
        }
        $newDots = array_merge($currentDots, $transposedDots);
        usort($newDots, function ($a, $b) {
            if ($a[1] < $b[1]) {
                return -1;
            } elseif ($a[1] > $b[1]) {
                return 1;
            } else {
                return $a[0] <=> $b[0];
            }
        });
        $unoverlappedDots = [];
        $previous = null;
        foreach ($newDots as $dot) {
            if ($dot !== $previous) {
                $unoverlappedDots[] = $dot;
            }
            $previous = $dot;
        }
        return new Paper($unoverlappedDots);
    }

    public function dots()
    {
        return $this->dots;
    }
}