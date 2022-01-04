<?php

namespace AdventOfCode\Day19;

class Beacon
{
    private $id;
    private $scannerId;
    public $x;
    public $y;
    public $z;

    public function __construct($scannerId, $coords)
    {
        $idFields = array_merge([$scannerId], $coords);
        $this->id = implode(':', $idFields);
        list($this->x, $this->y, $this->z) = $coords;
        $this->scannerId = $scannerId;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getVector(Beacon $target)
    {
        return new Vector(
            $this->x - $target->x,
            $this->y - $target->y,
            $this->z - $target->z
        );
    }

    public static function getTransform($index, $x, $y, $z)
    {
        switch ($index) {
            case 1:
                return [($x * -1), ($y * -1), $z];
            case 2:
                return [($x * -1), $y, ($z * -1)];
            case 3:
                return [$x, ($y * -1), ($z * -1)];
            case 4:
                return [($x * -1), $z, $y];
            case 5:
                return [$x, ($z * -1), $y];
            case 6:
                return [$x, $z, ($y * -1)];
            case 7:
                return [($x * -1), ($z * -1), ($y * -1)];
            case 8:
                return [($y * -1), $x, $z];
            case 9:
                return [$y, ($x * -1), $z];
            case 10:
                return [$y, $x, ($z * -1)];
            case 11:
                return [($y * -1), ($x * -1), ($z * -1)];
            case 12:
                return [$y, $z, $x];
            case 13:
                return [($y * -1), ($z * -1), $x];
            case 14:
                return [($y * -1), $z, ($x * -1)];
            case 15:
                return [$y, ($z * -1), ($x * -1)];
            case 16:
                return [$z, $x, $y];
            case 17:
                return [($z * -1), ($x * -1), $y];
            case 18:
                return [($z * -1), $x, ($y * -1)];
            case 19:
                return [$z, ($x * -1), ($y * -1)];
            case 20:
                return [($z * -1), $y, $x];
            case 21:
                return [$z, ($y * -1), $x];
            case 22:
                return [$z, $y, ($x * -1)];
            case 23:
                return [($z * -1), ($y * -1), ($x * -1)];
            default:
                return [$x, $y, $z];
        }
    }

    public function transform($index)
    {
        return new Beacon($this->scannerId, $this->getTransform($index, $this->x, $this->y, $this->z));
    }
}