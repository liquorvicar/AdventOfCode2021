<?php

namespace AdventOfCode;

class Answer08 extends Base
{
    private $digits = [
        'abcefg',
        'cf',
        'acdeg',
        'acdfg',
        'bcdf',
        'abdfg',
        'abdefg',
        'acf',
        'abcdefg',
        'abcdfg',
    ];

    public function one(array $input)
    {
        $entries = $this->getEntries($input);
        return array_reduce($entries, function ($count, $entry) {
            $uniques = array_filter($entry['outputs'], function ($value) {
                return in_array(strlen($value), [2, 3, 4, 7,]);
            });
            return $count + count($uniques);
        }, 0);
    }

    public function two(array $input)
    {
        $entries = $this->getEntries($input);
        $outputs = array_map(function ($input) {
            return $this->decodeOutput($input['signals'], $input['outputs']);
        }, $entries);
        return array_sum($outputs);
    }

    /**
     * @param array $input
     * @return array[]
     */
    private function getEntries(array $input): array
    {
        return array_map(function ($line) {
            $parts = explode('|', $line);
            $signals = $this->trim(explode(' ', trim($parts[0])));
            $outputs = $this->trim(explode(' ', trim($parts[1])));
            return ['signals' => $signals, 'outputs' => $outputs];
        }, array_filter($input));
    }

    public function decodeOutput(array $signals, array $outputs)
    {
        $digits = $this->digits;
        $candidates = $this->findMappingCandidates(array_merge($signals, $digits));
        $output = $this->findMapping($candidates, $signals, $outputs, $digits);
        $this->logger->debug('Output decoded!', ['output' => $output]);
        return $output;
    }

    private function findMapping($mapping, $signals, $outputs, $digits) {
        $unmapped = array_filter($mapping, function ($possibles) {
            return is_array($possibles);
        });
        if (empty($unmapped)) {
            $unmapped = array_filter($mapping, function ($possibles) {
                return is_null($possibles);
            });
            if (!empty($unmapped)) {
                return 0;
            }
            $mappedSignals = $this->mapInput($signals, $mapping);
            foreach ($mappedSignals as $mappedSignal) {
                if (!in_array($mappedSignal, $digits)) {
                    return 0;
                }
            }
            $mappedOutputs = $this->mapInput($outputs, $mapping);
            $sum = [];
            foreach ($mappedOutputs as $mappedOutput) {
                $digit = array_search($mappedOutput, $digits);
                if ($digit === false) {
                    return 0;
                }
                $sum[] = $digit;
            }
            $multiplier = 1;
            $outputSum = 0;
            while (!empty($sum)) {
                $digit = array_pop($sum);
                $outputSum+= ($digit * $multiplier);
                $multiplier = $multiplier * 10;
            }
            return $outputSum;
        }
        reset($unmapped);
        $letter = key($unmapped);
        $result = 0;
        foreach ($mapping[$letter] as $possible) {
            $newMapping = [];
            $newMapping[$letter] = $possible;
            foreach ($mapping as $newLetter => $possibles) {
                if ($newLetter !== $letter) {
                    if (is_array($possibles)) {
                        $candidates = array_filter($possibles, function ($thisPossible) use ($possible) {
                            return $thisPossible !== $possible;
                        });
                        if (empty($candidates)) {
                            $newMapping[$newLetter] = null;
                        } elseif (count($candidates) === 1) {
                            $newMapping[$newLetter] = array_pop($candidates);
                        } else {
                            $newMapping[$newLetter] = $candidates;
                        }
                    } else {
                        $newMapping[$newLetter] = $possibles;
                    }
                }
            }
            $result = $this->findMapping($newMapping, $signals, $outputs, $digits);
        }
        return $result;
    }

    private function mapInput($inputs, $mapping)
    {
        $mappedInputs = [];
        foreach ($inputs as $input) {
            $mapped = [];
            foreach (str_split($input) as $letter) {
                $mapped[] = $mapping[$letter];
            }
            sort($mapped);
            $mappedInputs[] = implode($mapped);
        }
        return $mappedInputs;
    }

    public function findMappingCandidates(array $entries)
    {
        $candidates = [];
        foreach ($entries as $entry) {
            $matching = array_filter($this->digits, function ($digit) use ($entry) {
                return strlen($digit) === strlen($entry);
            });
            $possibleLetters = array_reduce($matching, function ($possibles, $match) {
                $possibles = array_merge($possibles, str_split($match));
                sort($possibles);
                return array_values(array_unique($possibles));
            }, []);
            foreach (str_split($entry) as $letter) {
                if (!isset($candidates[$letter])) {
                    $candidates[$letter] = $possibleLetters;
                } else {
                    $candidates[$letter] = array_values(array_intersect($candidates[$letter], $possibleLetters));
                }
            }
        }
        $acted = true;
        while ($acted) {
            $acted = false;
            $singles = array_filter($candidates, function ($possibles) {
                return count($possibles) === 1;
            });
            if (!empty($singles)) {
                $newCandidates = [];
                foreach ($candidates as $letter => $possibles) {
                    if (in_array($letter, array_keys($singles))) {
                        $newCandidates[$letter] = $possibles;
                    } else {
                        $singleMappings = array_reduce($singles, function ($values, $possibles) {
                            return array_merge($values, $possibles);
                        }, []);
                        $newCandidates[$letter] = array_values(array_filter($possibles, function ($thisLetter) use ($singleMappings) {
                            return !in_array($thisLetter, $singleMappings);
                        }));
                        if ($newCandidates[$letter] !== $possibles) {
                            $acted = true;
                        }
                    }
                }
                $candidates = $newCandidates;
            }
            $doubles = [];
            foreach ($candidates as $letter => $possibles) {
                if (count($possibles) !== 2) {
                    continue;
                }
                $matches = array_filter($candidates, function ($candidate, $candidateLetter) use ($letter, $possibles) {
                    if ($candidateLetter === $letter) {
                        return false;
                    }
                    return $candidate === $possibles;
                }, ARRAY_FILTER_USE_BOTH);
                if (!empty($matches)) {
                    $thisDouble = array_merge(array_keys($matches), [$letter]);
                    sort($thisDouble);
                    $doubles[] = implode($thisDouble);
                }
            }
            $doubles = array_unique($doubles);
            foreach ($doubles as $double) {
                $excludes = $candidates[$double[0]];
                $newCandidates = [];
                foreach ($candidates as $letter => $possibles) {
                    if (strpos($double, $letter) !== false) {
                        $newCandidates[$letter] = $possibles;
                    } else {
                        $newCandidates[$letter] = array_values(array_filter($possibles, function ($thisLetter) use ($excludes) {
                            return !in_array($thisLetter, $excludes);
                        }));
                        if ($newCandidates[$letter] !== $possibles) {
                            $acted = true;
                        }
                    }
                }
                $candidates = $newCandidates;
            }
        }
        return $candidates;
    }
}

