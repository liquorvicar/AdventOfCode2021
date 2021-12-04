<?php

namespace AdventOfCode;

class Answer04 extends Base
{

    public function one(array $input)
    {
        list($numbers, $boards) = $this->processInput($input);
        foreach ($numbers as $calledNumber) {
            $newBoards = [];
            foreach ($boards as $board) {
                $newBoard = $this->markNumberCalled($board, $calledNumber);
                $winner = $this->checkWinner($newBoard);
                if ($winner) {
                    $sum = array_sum($newBoard);
                    return $sum * $calledNumber;
                }
                $newBoards[] = $newBoard;
            }
            $boards = $newBoards;
        }
        return 0;
    }

    public function two(array $input)
    {
        list($numbers, $boards) = $this->processInput($input);
        $this->logger->debug('Boards found', ['count' => count($boards)]);
        foreach ($numbers as $calledNumber) {
            $this->logger->debug('Number called', ['number' => $calledNumber]);
            $newBoards = [];
            $lastWinner = null;
            foreach ($boards as $board) {
                $newBoard = $this->markNumberCalled($board, $calledNumber);
                $winner = $this->checkWinner($newBoard);
                if (!$winner) {
                    $newBoards[] = $newBoard;
                } else {
                    $lastWinner = $newBoard;
                }
            }
            if (empty($newBoards)) {
                $sum = array_sum($lastWinner);
                return $sum * $calledNumber;
            }
            $boards = $newBoards;
        }
        return 0;
    }

    private function processInput(array $input) {

        $numbers = array_map(function ($value) { return (int)trim($value); }, explode(',', array_shift($input)));
        $boards = [];
        $thisBoard = [];
        while (!empty($input)) {
            $row = array_shift($input);
            if (empty($row)) {
                if (!empty($thisBoard)) {
                    $boards[] = $thisBoard;
                }
                $thisBoard = [];
                continue;
            }
            $rowNumbers = array_map(function ($value) { return (int)trim($value); }, array_filter(explode(' ', $row), function ($value) { return $value !== ''; }));
            $thisBoard = array_merge($thisBoard, $rowNumbers);
        }
        if (!empty($thisBoard)) {
            $boards[] = $thisBoard;
        }
        return [$numbers, $boards];
    }

    public function markNumberCalled(array $board, int $numberCalled)
    {
        $found = array_search($numberCalled, $board, true);
        if ($found !== false) {
            $board[$found] = null;
        }
        return $board;
    }

    public function checkWinner($board)
    {
        for ($i = 0; $i < 5; $i++) {
            $row = array_slice($board, ($i * 5), 5);
            $isWinner = array_filter($row, 'is_null');
            $winner = count($isWinner) === 5;
            if ($winner) {
                break;
            }
            $winner = true;
            for ($col = $i; $col < count($board); $col+=5) {
                if (!is_null($board[$col])) {
                    $winner = false;
                }
            }
            if ($winner) {
                break;
            }
        }
        return $winner;
    }
}
