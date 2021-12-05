<?php

namespace AdventOfCode\Day05;

class Line
{
    private Point $start;
    private Point $end;
    private bool $isStraight = false;
    private $orientation;

    const VERTICAL = 'vertical';
    const HORIZONTAL = 'horizontal';
    const DIAGONAL = 'diagonal';

    /**
     * @param Point $start
     * @param Point $end
     */
    public function __construct(Point $start, Point $end)
    {
        $this->start = $start;
        $this->end = $end;
        if ($this->start->x() === $this->end->x()) {
            $this->isStraight = true;
            $this->orientation = self::VERTICAL;
        } elseif ($this->start->y() === $this->end->y()) {
            $this->isStraight = true;
            $this->orientation = self::HORIZONTAL;
        } else {
            $this->orientation = self::DIAGONAL;
        }
    }

    /**
     * @return Point
     */
    public function getStart(): Point
    {
        return $this->start;
    }

    /**
     * @return Point
     */
    public function getEnd(): Point
    {
        return $this->end;
    }

    /**
     * @return bool
     */
    public function isStraight(): bool
    {
        return $this->isStraight;
    }

    /**
     * @return string
     */
    public function getOrientation(): string
    {
        return $this->orientation;
    }

    public function getPoints()
    {
        $points = [];
        if ($this->orientation === self::HORIZONTAL) {
            for ($i = $this->start->x(); $i <= $this->end->x(); $i++) {
                $points[] = new Point($i, $this->start->y());
            }
        } elseif ($this->orientation === self::VERTICAL) {
            for ($i = $this->start->y(); $i <= $this->end->y(); $i++) {
                $points[] = new Point($this->start->x(), $i);
            }
        } else {
            $xVector = $this->start->x() < $this->end->x() ? 1 : -1;
            $yVector = $this->start->y() < $this->end->y() ? 1 : -1;
            $x = $this->start->x();
            $y = $this->start->y();
            for ($i = 0; $i <= abs($this->end->x() - $this->start->x()); $i++) {
                $points[] = new Point($x, $y);
                $x+= $xVector;
                $y+= $yVector;
            }
        }
        return $points;
    }

    public static function fromString(string $input)
    {
        $points = explode('->', $input);
        $startPoints = explode(',', $points[0]);
        $endPoints = explode(',', $points[1]);
        $one = Point::fromStrings($startPoints[0], $startPoints[1]);
        $two = Point::fromStrings($endPoints[0], $endPoints[1]);
        if ($one->x() < $two->x() || $one->y() < $two->y()) {
            return new Line($one, $two);
        } else {
            return new Line($two, $one);
        }
    }
}