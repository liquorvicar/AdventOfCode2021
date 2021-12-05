<?php

namespace AdventOfCode\Day05;

class Point
{
    private $x;
    private $y;

    /**
     * @param $x
     * @param $y
     */
    public function __construct($x, $y)
    {
        $this->x = $x;
        $this->y = $y;
    }

    /**
     * @return mixed
     */
    public function x()
    {
        return $this->x;
    }

    /**
     * @return mixed
     */
    public function y()
    {
        return $this->y;
    }

    public function getKey()
    {
        return "$this->x:$this->y";
    }

    public static function fromStrings(string $x, string $y)
    {
        return new self((int)$x, (int)$y);
    }
}