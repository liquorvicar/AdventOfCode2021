<?php

namespace AdventOfCode\Day18;

class Number
{
    private $number;

    private const LEFT = 'left';
    private const RIGHT = 'right';

    public function __construct($number)
    {
        $this->number = $number;
    }

    public function runAction()
    {
        $explodePos = 0;
        $depth = 0;
        $pair = '';
        foreach (str_split($this->number) as $pos => $digit) {
            if ($digit === '[') {
                $depth++;
                $pair = '';
            } elseif ($digit === ']') {
                $depth--;
                if (!empty($pair)) {
                    $explodePos = $pos;
                    $pair = "[$pair]";
                    break;
                }
            } elseif ($depth > 4) {
                $pair.= $digit;
            }
        }
        if (empty($pair)) {
            return $this->split();
        }
        $explodePos-= (strlen($pair) - 1);
        $newNumber = substr($this->number, 0, $explodePos) . '0' . substr($this->number, $explodePos + strlen($pair));
        $digits = explode(',', trim($pair, '[]'));
        $newNumber = $this->explode($explodePos, $newNumber, $digits[1], self::RIGHT);
        $newNumber = $this->explode($explodePos, $newNumber, $digits[0], self::LEFT);
        return new Number($newNumber);
    }

    public function toString()
    {
        return $this->number;
    }

    private function explode(int $explodePos, string $newNumber, $explodedDigit, $direction): string
    {
        $found = false;
        $digit = '';
        while (!$found && $explodePos > 0 && $explodePos < strlen($newNumber)) {
            if ($direction === self::LEFT) {
                $explodePos--;
            } else {
                $explodePos++;
            }
            $thisDigit = substr($newNumber, $explodePos, 1);
            if (!in_array($thisDigit, ['[', ']', ','])) {
                if ($direction === self::RIGHT) {
                    $digit .= $thisDigit;
                } else {
                    $digit = $thisDigit . $digit;
                }
            } elseif (strlen($digit) > 0) {
                $found = true;
                $newDigit = (int)$digit + (int)$explodedDigit;
                if ($direction === self::LEFT) {
                    $start = $explodePos + 1;
                    $end = $explodePos + strlen($digit) + 1;
                } else {
                    $start = $explodePos - strlen($digit);
                    $end = $explodePos;
                }
                $newNumber = substr($newNumber, 0, $start) . $newDigit . substr($newNumber, $end);
            }
        }
        return $newNumber;
    }

    private function split()
    {
        $matches = [];
        preg_match('/[0-9]{2}/', $this->number, $matches, PREG_OFFSET_CAPTURE);
        if (!isset($matches[0])) {
            return false;
        }
        $numberToSplit = $matches[0][0];
        $offset = $matches[0][1];
        $newPair = '[' . floor($numberToSplit/2) . ',' . ceil($numberToSplit/2) . ']';
        $newNumber = substr($this->number, 0, $offset) . $newPair . substr($this->number, $offset + strlen($numberToSplit));
        return new Number($newNumber);
    }

    public function calculateMagnitude()
    {
        $magnitude = 0;
        $number = $this->number;
        $found = true;
        while ($found) {
            $matches = [];
            preg_match('/(\[[0-9]+,[0-9]+\])/', $number, $matches);
            if (empty($matches)) {
                $found = false;
            } else {
                $pair = explode(',', trim($matches[1], '[]'));
                $magnitude = (3 * (int)$pair[0]) + (2 * (int)$pair[1]);
                $number = str_replace($matches[1], $magnitude, $number);
            }
        }
        return $magnitude;
    }
}