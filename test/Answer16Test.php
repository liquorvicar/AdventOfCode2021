<?php

namespace AdventOfCode;

class Answer16Test extends BaseTest
{
    /**
     * @var Answer16
     */
    protected $answer;

    public function setUp(): void
    {
        parent::setUp();
        $this->answer = new Answer16($this->logger);
    }

    /**
     * @param $hex
     * @param $bits
     * @dataProvider dataForConvertHexToBits
     */
    public function testConvertHexToBits($hex, $bits)
    {
        $this->assertEquals($bits, $this->answer->convertHexToBits($hex));
    }

    public function dataForConvertHexToBits()
    {
        return [
            ['D2FE28', '110100101111111000101000',],
            ['38006F45291200', '00111000000000000110111101000101001010010001001000000000',],
        ];
    }

    /**
     * @param $bits
     * @param $packets
     * @dataProvider dataForParsePackets
     */
    public function testParsePackets($bits, $packets)
    {
        $this->assertEquals($packets, $this->answer->parsePackets($bits));
    }

    public function dataForParsePackets()
    {
        return [
            ['110100101111111000101000', [['version' => 6, 'type' => 4, 'value' => 2021,]]],
            [
                '00111000000000000110111101000101001010010001001000000000',
                [
                    [
                        'version' => 1,
                        'type' => 6,
                        'sub-packets' => [
                            ['version' => 6, 'type' => 4, 'value' => 10,],
                            ['version' => 2, 'type' => 4, 'value' => 20,],
                        ]
                    ]
                ]
            ],
            [
                '11101110000000001101010000001100100000100011000001100000',
                [
                    [
                        'version' => 7,
                        'type' => 3,
                        'sub-packets' => [
                            ['version' => 2, 'type' => 4, 'value' => 1,],
                            ['version' => 4, 'type' => 4, 'value' => 2,],
                            ['version' => 1, 'type' => 4, 'value' => 3,],
                        ]
                    ]
                ]
            ]
        ];
    }

    /**
     * @param $input
     * @param $expected
     * @dataProvider dataForOne
     */
    public function testOne($input, $expected)
    {
        $this->assertEquals($expected, $this->answer->one($input));
    }

    public function dataForOne()
    {
        return [
            [['8A004A801A8002F478'], 16],
            [['620080001611562C8802118E34'], 12],
            [['C0015000016115A2E0802F182340'], 23],
            [['A0016C880162017C3686B18A3D4780'], 31],
        ];
    }

    /**
     * @param $hex
     * @param $expected
     * @dataProvider dataForTwo
     */
    public function testTwo($hex, $expected)
    {
        $this->assertEquals($expected, $this->answer->two([$hex]));
    }

    public function dataForTwo()
    {
        return [
            ['C200B40A82', 3],
            ['04005AC33890', 54],
            ['880086C3E88112', 7],
            ['CE00C43D881120', 9],
            ['D8005AC2A8F0', 1],
            ['F600BC2D8F', 0],
            ['9C005AC2F8F0', 0],
            ['9C0141080250320F1802104A08', 1],
        ];
    }
}
