<?php

namespace AdventOfCode;

use AdventOfCode\Day12\Cave;

class Answer12 extends Base
{

    public function one(array $cavePaths)
    {
        $caves = [];
        foreach ($cavePaths as $cavePath) {
            $theseCaves = explode('-', $cavePath);
            if (!isset($caves[$theseCaves[0]])) {
                $caves[$theseCaves[0]] = Cave::fromName($theseCaves[0]);
            }
            $caves[$theseCaves[0]]->addExit($theseCaves[1]);
            if (!isset($caves[$theseCaves[1]])) {
                $caves[$theseCaves[1]] = Cave::fromName($theseCaves[1]);
            }
            $caves[$theseCaves[1]]->addExit($theseCaves[0]);
        }
        return count($this->findPaths('start', $caves, [], []));
    }

    private function findPaths(string $nextCave, array $caves, array $path, array $paths)
    {
        $path[] = $nextCave;
        if ($nextCave === 'end') {
            $paths[] = $path;
            return $paths;
        }
        $cave = $caves[$nextCave];
        foreach ($cave->getExits(false) as $exit) {
            $newCave = clone $cave;
            $newCave->visit();
            $newCave->useExit($exit);
            $caves[$nextCave] = $newCave;
            $paths = $this->findPaths($exit, $caves, $path, $paths);
        }
        return $paths;
    }

    public function two(array $cavePaths)
    {
        $caves = [];
        foreach ($cavePaths as $cavePath) {
            $theseCaves = explode('-', $cavePath);
            if (!isset($caves[$theseCaves[0]])) {
                $caves[$theseCaves[0]] = Cave::fromName($theseCaves[0]);
            }
            $caves[$theseCaves[0]]->addExit($theseCaves[1]);
            if (!isset($caves[$theseCaves[1]])) {
                $caves[$theseCaves[1]] = Cave::fromName($theseCaves[1]);
            }
            $caves[$theseCaves[1]]->addExit($theseCaves[0]);
        }
        return count($this->findPathsCanVisitSomeTwice('start', $caves, [], [], true));
    }

    private function findPathsCanVisitSomeTwice(string $nextCave, array $caves, array $path, array $paths, bool $canVisitTwice)
    {
        $path[] = $nextCave;
        if ($nextCave === 'end') {
            $paths[] = $path;
            return $paths;
        }
        $cave = $caves[$nextCave];
        if ($cave->isSmallCave() && $cave->isVisited()) {
            if (!$canVisitTwice) {
                return $paths;
            } else {
                $canVisitTwice = false;
            }
        }
        foreach ($cave->getExits($canVisitTwice) as $exit) {
            $newCave = clone $cave;
            $newCave->visit();
            $newCave->useExit($exit);
            $caves[$nextCave] = $newCave;
            $paths = $this->findPathsCanVisitSomeTwice($exit, $caves, $path, $paths, $canVisitTwice);
        }
        return $paths;
    }
}

