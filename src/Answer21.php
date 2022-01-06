<?php

namespace AdventOfCode;

use AdventOfCode\Day21\DeterministicDie;
use AdventOfCode\Day21\Player;

class Answer21 extends Base
{

    public function one(array $input)
    {
        $players = $this->getStartingPositions($input);
        $players = [new Player(1, $players[0]), new Player(2, $players[1])];
        $gameOver = false;
        $nextTurn = 0;
        $die = new DeterministicDie(1);
        while (!$gameOver) {
            $players[$nextTurn]->takeTurn($die);
            if ($players[$nextTurn]->getScore() >= 1000) {
                $gameOver = true;
            }
            $nextTurn = $nextTurn === 0 ? 1 : 0;
        }
        $loser = $players[$nextTurn];
        return $loser->getScore() * $die->timesRolled();
    }

    public function two(array $input)
    {
        $players = $this->getStartingPositions($input);
        $wins = $this->playGames($players, [0, 0], 0, 1, [0, 0], 21);
        rsort($wins);
        return $wins[0];
    }

    public function getStartingPositions(array $input)
    {
        return array_map(function ($line) {
            $parts = explode(':', $line);
            return (int)$parts[1];
        }, $input);
    }

    private function playGames(array $positions, array $scores, int $turn, $perms, array $wins, int $target)
    {
        if ($scores[0] >= $target) {
            $wins[0]+= $perms;
            return $wins;
        }
        if ($scores[1] >= $target) {
            $wins[1]+= $perms;
            return $wins;
        }
        $possibleScores = [];
        for ($roll1 = 1; $roll1 <= 3; $roll1++) {
            for ($roll2 = 1; $roll2 <= 3; $roll2++) {
                for ($roll3 = 1; $roll3 <= 3; $roll3++) {
                    $thisScore = $roll1 + $roll2 + $roll3;
                    if (!isset($possibleScores[$thisScore])) {
                        $possibleScores[$thisScore] = 0;
                    }
                    $possibleScores[$thisScore]++;
                }
            }
        }
        $nextTurn = $turn === 0 ? 1 : 0;
        foreach ($possibleScores as $possibleScore => $scorePerms) {
            $newPositions = $positions;
            $newScores = $scores;
            $newPositions[$turn] = ($newPositions[$turn] + $possibleScore) % 10;
            if ($newPositions[$turn] === 0) {
                $newPositions[$turn] = 10;
            }
            $newScores[$turn]+= $newPositions[$turn];
            $wins = $this->playGames($newPositions, $newScores, $nextTurn, ($perms * $scorePerms), $wins, $target);
        }
        return $wins;
    }
}
