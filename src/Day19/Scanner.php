<?php

namespace AdventOfCode\Day19;

class Scanner
{
    private $id;
    private $beacons = [];
    private $position;
    private $orientation;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public static function create(string $string)
    {
        if (strpos($string, 'scanner') === false) {
            return null;
        }
        $id = str_replace(['---', 'scanner', ' '], '', $string);
        return new self((int)$id);
    }

    public function getId()
    {
        return $this->id;
    }

    public function addBeacon(string $beacon)
    {
        $coords = explode(',', $beacon);
        $coords = array_map(function ($coord) {
            return (int)$coord;
        }, $coords);
        $this->beacons[] = new Beacon($this->id, $coords);
    }

    public function getBeacons()
    {
        return $this->beacons;
    }

    public function setPosition($position)
    {
        $this->position = $position;
    }

    public function getPosition()
    {
        return $this->position;
    }

    public function setOrientation($orientation)
    {
        $this->orientation = $orientation;
        $this->beacons = array_map(function ($beacon) use ($orientation) {
            return $beacon->transform($orientation);
        }, $this->beacons);
    }

    public function getOrientation()
    {
        return $this->orientation;
    }

    public function hasPosition()
    {
        return !is_null($this->position);
    }
}