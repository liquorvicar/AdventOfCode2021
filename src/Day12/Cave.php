<?php

namespace AdventOfCode\Day12;

class Cave
{
    private $name;
    protected $exits = [];
    protected $visited = false;
    protected $usedExits = [];

    /**
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function visit()
    {
        $this->visited = true;
    }

    public function useExit(string $exit)
    {
        $this->usedExits[] = $exit;
    }

    public function isVisited()
    {
        return $this->visited;
    }

    public static function fromName(string $name)
    {
        $uppercase = preg_replace('/[a-z]/', '', $name);
        if (empty($uppercase)) {
            return new SmallCave($name);
        } else {
            return new BigCave($name);
        }
    }

    public function getSize()
    {
        return $this->size;
    }

    public function addExit(string $exit)
    {
        if ($exit !== 'start') {
            $this->exits[] = $exit;
        }
    }
}