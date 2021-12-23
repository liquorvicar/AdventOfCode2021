<?php

namespace AdventOfCode;

use AdventOfCode\Day16\Packet;

class Answer16 extends Base
{

    public function one(array $input)
    {
        $hex = $input[0];
        $bits = $this->convertHexToBits($hex);
        $packets = $this->parsePackets($bits);
        return $this->sumVersions($packets, 0);
    }

    private function sumVersions($packets, $sum) {
        return array_reduce($packets, function ($sum, $packet) {
            $sum+= $packet['version'];
            if (isset($packet['sub-packets'])) {
                $sum = $this->sumVersions($packet['sub-packets'], $sum);
            }
            return $sum;
        }, $sum);
    }

    public function two(array $input)
    {
        $hex = $input[0];
        $bits = $this->convertHexToBits($hex);
        $packets = $this->parsePackets($bits);
        $packet = array_pop($packets);
        return $this->findValue($packet);
    }

    public function convertHexToBits($hex)
    {
        $mapping = [
            '0' => '0000',
            '1' => '0001',
            '2' => '0010',
            '3' => '0011',
            '4' => '0100',
            '5' => '0101',
            '6' => '0110',
            '7' => '0111',
            '8' => '1000',
            '9' => '1001',
            'A' => '1010',
            'B' => '1011',
            'C' => '1100',
            'D' => '1101',
            'E' => '1110',
            'F' => '1111',
        ];
        $bits = '';
        foreach (str_split($hex) as $hexChar) {
            $bits.= $mapping[$hexChar];
        }
        return $bits;
    }

    public function parsePackets($bits)
    {
        $packets = [];
        $thisPacket = new Packet();
        foreach (str_split($bits) as $bit) {
            $thisPacket->addBit($bit);
            if ($thisPacket->isComplete()) {
                $packets[] = $thisPacket;
                $thisPacket = new Packet();
            }
        }
        return array_map(function ($packet) {
            return $packet->toArray();
        }, $packets);
    }

    private function findValue(mixed $packet)
    {
        if (isset($packet['value'])) {
            return $packet['value'];
        }
        $values = array_map(function ($packet) {
            return $this->findValue($packet);
        }, $packet['sub-packets']);
        $value = 0;
        switch ($packet['type']) {
            case 0:
                $value = array_sum($values);
                break;
            case 1:
                $value = array_reduce($values, function ($total, $value) {
                    return $total * $value;
                }, 1);
                break;
            case 2:
                sort($values);
                $value = $values[0];
                break;
            case 3:
                rsort($values);
                $value = $values[0];
                break;
            case 5:
                $value = $values[0] > $values[1] ? 1 : 0;
                break;
            case 6:
                $value = $values[0] < $values[1] ? 1 : 0;
                break;
            case 7:
                $value = $values[0] === $values[1] ? 1 : 0;
                break;
        }
        return $value;
    }
}

