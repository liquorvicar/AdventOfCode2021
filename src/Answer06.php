<?php

namespace AdventOfCode;

class Answer06 extends Base
{

    public function one(array $input)
    {
        $fish = $this->numbers(explode(',', $input[0]));
        return $this->modelCycles($fish, 80);
    }

    public function two(array $input)
    {
        $fish = $this->numbers(explode(',', $input[0]));
        return $this->modelCycles($fish, 256);
    }

    public function modelCycles(array $fish, int $cycles)
    {
        $groupedFish = [0 => 0, 1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0, 6 => 0, 7 => 0, 8 => 0,];
        foreach ($fish as $oneFish) {
            $groupedFish[$oneFish]++;
        }
        while ($cycles > 0) {
            $groupedFish = $this->modelCycle($groupedFish);
            $cycles--;
        }
        return array_sum(array_values($groupedFish));;
    }

    private function modelCycle(array $fish)
    {
        return [
            0 => $fish[1],
            1 => $fish[2],
            2 => $fish[3],
            3 => $fish[4],
            4 => $fish[5],
            5 => $fish[6],
            6 => ($fish[0] + $fish[7]),
            7 => $fish[8],
            8 => $fish[0],
        ];
    }
}

