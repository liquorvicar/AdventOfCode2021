<?php

namespace AdventOfCode;

use Psr\Log\LoggerInterface;

class Answer01
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function one(Array $input) {
        $this->logger->info('Running part one');
        $depths = array_filter(array_map(function ($value) {
            return (int)$value;
        }, $input));
        return $this->countIncreases($depths);
    }

    public function two(Array $input) {
        $this->logger->info('Running part two');
        $depths = array_filter(array_map(function ($value) {
            return (int)$value;
        }, $input));
        return $this->countIncreasesInWindows($depths);
    }

    public function countIncreases(array $input)
    {
        $last = 0;
        $increases = 0;
        foreach ($input as $depth) {
            if ($last > 0 && $depth > $last) {
                $increases++;
            }
            $last = $depth;
        }
        return $increases;
    }

    public function countIncreasesInWindows(array $input)
    {
        $increases = 0;
        $previousWindow = [];
        $currentWindow = [];
        foreach ($input as $depth) {
            $currentWindow[] = $depth;
            if (count($previousWindow) === 3 && count($currentWindow) === 3) {
                if (array_sum($currentWindow) > array_sum($previousWindow)) {
                    $increases++;
                }
            }
            $previousWindow = $currentWindow;
            if (count($currentWindow) === 3) {
                array_shift($currentWindow);
            }
        }
        return $increases;
    }
}

