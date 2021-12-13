<?php

namespace AdventOfCode;

use AdventOfCode\Day13\Paper;

class Answer13 extends Base
{

    public function one(array $input)
    {
        $dots = [];
        $folds = [];
        foreach ($input as $line) {
            if (empty($line)) {
                continue;
            } elseif (strpos($line, 'fold') === false) {
                $theseDots = explode(',', $line);
                $dots[] = [
                    (int)$theseDots[0],
                    (int)$theseDots[1],
                ];
            } else {
                $line = str_replace('fold along ', '', $line);
                $thisFold = explode('=', $line);
                $folds[] = [
                    $thisFold[0],
                    (int)$thisFold[1],
                ];
            }
        }
        $paper = new Paper($dots);
        $paper = $paper->fold($folds[0][0], $folds[0][1]);
        return count($paper->dots());
    }

    public function two(array $input)
    {
        $dots = [];
        $folds = [];
        foreach ($input as $line) {
            if (empty($line)) {
                continue;
            } elseif (strpos($line, 'fold') === false) {
                $theseDots = explode(',', $line);
                $dots[] = [
                    (int)$theseDots[0],
                    (int)$theseDots[1],
                ];
            } else {
                $line = str_replace('fold along ', '', $line);
                $thisFold = explode('=', $line);
                $folds[] = [
                    $thisFold[0],
                    (int)$thisFold[1],
                ];
            }
        }
        $paper = new Paper($dots);
        foreach ($folds as $fold) {
            $paper = $paper->fold($fold[0], $fold[1]);
        }
        $x = 0;
        $y = 0;
        $dots = $paper->dots();
        $allXs = array_map(function ($dot) {
            return $dot[0];
        }, $dots);
        rsort($allXs);
        $maxX = $allXs[0];
        $dot = array_shift($dots);
        while (!empty($dot)) {
            if ($y < $dot[1] || ($y === $dot[1] && $x < $dot[0])) {
                echo '.';
            } elseif ($y === $dot[1] && $x === $dot[0]) {
                echo '#';
                $dot = array_shift($dots);
            }
            $x++;
            if ($x > $maxX) {
                $y++;
                $x = 0;
                echo PHP_EOL;
            }
        }
        return 0;
    }
}

