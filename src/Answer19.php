<?php

namespace AdventOfCode;

use AdventOfCode\Day19\Scanner;

class Answer19 extends Base
{

    public function one(array $input)
    {
        $scanners = $this->parseScanners($input);
        $scanners[0]->setPosition([0, 0, 0]);
        $scanners[0]->setOrientation(0);
        $scanners = $this->positionScanners($scanners);
        $beacons = $this->findBeacons($scanners);
        return count($beacons);
    }

    public function two(array $input)
    {
        $scanners = $this->parseScanners($input);
        $scanners[0]->setPosition([0, 0, 0]);
        $scanners[0]->setOrientation(0);
        $scanners = $this->positionScanners($scanners);
        $positions = array_map(function (Scanner $scanner) {
            return $scanner->getPosition();
        }, $scanners);
        return $this->findLargestDistance($positions);
    }

    public function parseScanners(array $input)
    {
        $scanners = [];
        $scanner = null;
        foreach ($input as $line) {
            if (empty($line)) {
                continue;
            }
            $newScanner = Scanner::create($line);
            if ($newScanner) {
                $scanners[] = $scanner;
                $scanner = $newScanner;
            } else {
                $scanner->addBeacon($line);
            }
        }
        $scanners[] = $scanner;
        return array_values(array_filter($scanners));
    }

    public function findOverLapPosition(Scanner $first, Scanner $second)
    {
        $overlap = [];
        foreach ($first->getBeacons() as $firstBeacon) {
            $firstVectors = [];
            foreach ($first->getBeacons() as $targetBeacon) {
                if ($firstBeacon->getId() === $targetBeacon->getId()) {
                    continue;
                }
                $firstVectors[] = $firstBeacon->getVector($targetBeacon);
            }
            $secondBeacons = $second->getBeacons();
            $transform = 0;
            while ($transform < 24) {
                $transformedBeacons = array_map(function ($beacon) use ($transform) {
                    return $beacon->transform($transform);
                }, $secondBeacons);
                foreach ($transformedBeacons as $secondBeacon) {
                    $secondVectors = [];
                    foreach ($transformedBeacons as $targetBeacon) {
                        if ($secondBeacon->getId() === $targetBeacon->getId()) {
                            continue;
                        }
                        $secondVectors[] = $secondBeacon->getVector($targetBeacon);
                    }
                    $overlappingBeacons = array_intersect($firstVectors, $secondVectors);
                    if (count($overlappingBeacons) >= 11) {
                        $beaconOne = $firstBeacon;
                        $beaconTwo = $secondBeacon;
                        list($firstX, $firstY, $firstZ) = $first->getPosition();
                        $overlap = [
                            $firstX + ($beaconOne->x - $beaconTwo->x),
                            $firstY + ($beaconOne->y - $beaconTwo->y),
                            $firstZ + ($beaconOne->z - $beaconTwo->z),
                        ];
                        break 3;
                    }
                }
                $transform++;
            }
        }
        return [$overlap, $transform];
    }

    public function positionScanners(array $scanners)
    {
        $allFound = false;
        while (!$allFound) {
            $found = array_filter($scanners, function (Scanner $scanner) {
                return $scanner->hasPosition();
            });
            $notFound = array_filter($scanners, function (Scanner $scanner) {
                return !$scanner->hasPosition();
            });
            if (empty($notFound)) {
                $allFound = true;
            }
            foreach ($notFound as $scannerToPlace) {
                foreach ($found as $placedScanner) {
                    list($position, $orientation) = $this->findOverLapPosition($placedScanner, $scannerToPlace);
                    if (!empty($position)) {
                        $scannerToPlace->setPosition($position);
                        $scannerToPlace->setOrientation($orientation);
                        $this->logger->debug('Scanner placed', ['scanner' => $scannerToPlace->getId(), 'found' => count($found) + 1]);
                        break 2;
                    }
                }
            }
        }
        return $scanners;
    }

    public function findBeacons(array $scanners)
    {
        $beacons = [];
        foreach ($scanners as $scanner) {
            list($x, $y, $z) = $scanner->getPosition();
            foreach ($scanner->getBeacons() as $thisBeacon) {
                $coords = [
                    $x + $thisBeacon->x,
                    $y + $thisBeacon->y,
                    $z + $thisBeacon->z
                ];
                $key = implode(':', $coords);
                if (!isset($beacons[$key])) {
                    $beacons[$key] = $coords;
                }
            }
        }
        sort($beacons);
        return array_values($beacons);
    }

    public function findLargestDistance(array $positions)
    {
        $largestDistance = 0;
        foreach ($positions as $firstKey => $firstPosition) {
            foreach ($positions as $secondKey => $secondPosition) {
                if ($firstKey === $secondKey) {
                    continue;
                }
                $distance = abs($firstPosition[0] - $secondPosition[0])
                    + abs($firstPosition[1] - $secondPosition[1])
                    + abs($firstPosition[2] - $secondPosition[2]);
                $largestDistance = $distance > $largestDistance ? $distance : $largestDistance;
            }
        }
        return $largestDistance;
    }
}

