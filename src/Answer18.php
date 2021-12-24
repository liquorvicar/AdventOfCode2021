<?php

namespace AdventOfCode;

use AdventOfCode\Day18\Number;

class Answer18 extends Base
{

    public function one(array $input)
    {
        $one = new Number(array_shift($input));
        while (!empty($input)) {
            $two = array_shift($input);
            if (empty($two)) {
                continue;
            }
            $one = $this->add($one->toString(), $two);
        }
        return $one->calculateMagnitude();
    }

    public function two(array $input)
    {
        $magnitude = 0;
        foreach ($input as $one => $first) {
            foreach ($input as $two => $second) {
                if ($one !== $two && !empty($first) && !empty($second)) {
                    $add = $this->add($first, $second);
                    if ($add->calculateMagnitude() > $magnitude) {
                        $magnitude = $add->calculateMagnitude();
                    }
                }
            }
        }
        return $magnitude;
    }

    public function add(string $one, string $two)
    {
        $newNumber = new Number("[$one,$two]");
        $lastNumber = $newNumber;
        while ($newNumber) {
            $newNumber = $newNumber->runAction();
            $lastNumber = $newNumber ?: $lastNumber;
        }
        return $lastNumber;
    }
}

