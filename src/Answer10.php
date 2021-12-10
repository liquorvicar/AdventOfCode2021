<?php

namespace AdventOfCode;

class Answer10 extends Base
{

    public function one(array $input)
    {
        $scores = [
            ')' => 3,
            ']' => 57,
            '}' => 1197,
            '>' => 25137,
        ];
        $score = 0;
        foreach ($input as $line) {
            $illegal = $this->findFirstIllegalCharacter($line);
            if (!is_array($illegal)) {
                $score += $scores[$illegal];
            }
        }
        return $score;
    }

    public function two(array $input)
    {
        $scores = [
            ')' => 1,
            ']' => 2,
            '}' => 3,
            '>' => 4,
        ];
        $completionScores = [];
        foreach ($input as $line) {
            $illegal = $this->findFirstIllegalCharacter($line);
            if (is_array($illegal)) {
                $score = 0;
                foreach ($illegal as $closer) {
                    $score = $score * 5;
                    $score+= $scores[$closer];
                }
                $completionScores[] = $score;
            }
        }
        sort($completionScores);
        return $completionScores[floor(count($completionScores)/2)];
    }

    public function findFirstIllegalCharacter($line)
    {
        $openers = ['{','[','(','<'];
        $closers = ['}',']',')','>'];
        $opens = [];
        foreach (str_split($line) as $char) {
            if (in_array($char, $openers)) {
                $opens[] = $char;
            } elseif (in_array($char, $closers)) {
                $opener = array_pop($opens);
                if (!$opener) {
                    throw new \Exception('Closer found without opener');
                }
                $openRef = array_search($opener, $openers);
                $expectedCloser = $closers[$openRef];
                if ($char !== $expectedCloser) {
                    return $char;
                }
            }
        }
        $missingClosers = array_reverse($opens);
        return array_map(function ($opener) use ($openers, $closers) {
            $openRef = array_search($opener, $openers);
            return $closers[$openRef];
        }, $missingClosers);
    }
}

