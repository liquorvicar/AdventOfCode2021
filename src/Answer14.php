<?php

namespace AdventOfCode;

class Answer14 extends Base
{

    public function one(array $input)
    {
        return $this->processSteps($input, 10);
    }

    public function two(array $input)
    {
        list($template, $rules) = $this->parseInput($input);
        $pairs = [];
        for ($i = 0; $i < strlen($template); $i++) {
            $pair = substr($template, $i, 2);
            if (strlen($pair) === 2) {
                if (!isset($pairs[$pair])) {
                    $pairs[$pair] = 0;
                }
                $pairs[$pair]++;
            }
        }
        for ($i = 1; $i <= 40; $i++) {
            $newPairs = [];
            foreach ($rules as $originalPair => $extraLetter) {
                $firstPair = substr($originalPair, 0, 1) . $extraLetter;
                $secondPair = $extraLetter . substr($originalPair, 1, 1);
                if (!isset($newPairs[$firstPair])) {
                    $newPairs[$firstPair] = 0;
                }
                if (!isset($newPairs[$secondPair])) {
                    $newPairs[$secondPair] = 0;
                }
                $newPairs[$firstPair] += $pairs[$originalPair] ?? 0;
                $newPairs[$secondPair] += $pairs[$originalPair] ?? 0;
            }
            $pairs = $newPairs;
        }
        $letters = [];
        foreach ($pairs as $pair => $count) {
            foreach (str_split($pair) as $letter) {
                if (!isset($letters[$letter])) {
                    $letters[$letter] = 0;
                }
                $letters[$letter]+= $count;
            }
        }
        asort($letters);
        $least = array_shift($letters);
        $most = array_pop($letters);
        return ($most - $least + 1) / 2;
    }

    public function processSteps($input, $steps)
    {
        list($template, $rules) = $this->parseInput($input);
        while ($steps > 0) {
            $this->logger->debug('Processing step', ['step' => $steps]);
            $template = $this->processStep($template, $rules);
            $steps--;
        }
        $letters = str_split($template);
        $counts = array_reduce($letters, function ($counts, $letter) {
            if (!isset($counts[$letter])) {
                $counts[$letter] = 0;
            }
            $counts[$letter]++;
            return $counts;
        }, []);
        asort($counts);
        $least = array_shift($counts);
        $most = array_pop($counts);
        return $most - $least;
    }

    public function processStep(mixed $template, array $rules)
    {
        $newTemplate = '';
        $currentTemplate = str_split($template);
        while (count($currentTemplate) > 1) {
            $currentLetter = array_shift($currentTemplate);
            $newTemplate.= $currentLetter;
            $nextLetter = reset($currentTemplate);
            $pair = $currentLetter . $nextLetter;
            if (isset($rules[$pair])) {
                $newTemplate.= $rules[$pair];
            }
        }
        $lastLetter = array_shift($currentTemplate);
        $newTemplate.= $lastLetter;
        return $newTemplate;
    }

    private function parseInput($input)
    {
        $template = array_shift($input);
        $rules = [];
        foreach ($input as $rawRule) {
            if (empty($rawRule)) {
                continue;
            }
            $matches = [];
            preg_match('/^([A-Z]{2}) -> ([A-Z])$/', $rawRule, $matches);
            $rules[$matches[1]] = $matches[2];
        }
        return [$template, $rules];
    }
}

