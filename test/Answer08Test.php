<?php

namespace AdventOfCode;

class Answer08Test extends BaseTest
{
    /**
     * @var Answer08
     */
    protected $answer;

    public function setUp(): void
    {
        parent::setUp();
        $this->answer = new Answer08($this->logger);
    }

    public function testOne()
    {
        $input = [
            'be cfbegad cbdgef fgaecd cgeb fdcge agebfd fecdb fabcd edb | fdgacbe cefdb cefbgd gcbe',
            'edbfga begcd cbg gc gcadebf fbgde acbgfd abcde gfcbed gfec | fcgedb cgb dgebacf gc',
            'fgaebd cg bdaec gdafb agbcfd gdcbef bgcad gfac gcb cdgabef | cg cg fdcagb cbg',
            'fbegcd cbd adcefb dageb afcb bc aefdc ecdab fgdeca fcdbega | efabcd cedba gadfec cb',
            'aecbfdg fbg gf bafeg dbefa fcge gcbea fcaegb dgceab fcbdga | gecf egdcabf bgf bfgea',
            'fgeab ca afcebg bdacfeg cfaedg gcfdb baec bfadeg bafgc acf | gebdcfa ecba ca fadegcb',
            'dbcfg fgd bdegcaf fgec aegbdf ecdfab fbedc dacgb gdcebf gf | cefg dcbef fcge gbcadfe',
            'bdfegc cbegaf gecbf dfcage bdacg ed bedf ced adcbefg gebcd | ed bcgafe cdgba cbgef',
            'egadfb cdbfeg cegd fecab cgb gbdefca cg fgcdab egfdb bfceg | gbdfcae bgc cg cgb',
            'gcafb gcf dcaebfg ecagb gf abcdeg gaef cafbge fdbac fegbdc | fgae cfgab fg bagce',
        ];
        $this->assertEquals(26, $this->answer->one($input));
    }

    public function testDecodeOutput()
    {
        $this->assertEquals(5353, $this->answer->decodeOutput(
            ['acedgfb', 'cdfbe', 'gcdfa', 'fbcad', 'dab', 'cefabd', 'cdfgeb', 'eafb', 'cagedb', 'ab',],
            ['cdfeb', 'fcadb', 'cdfeb', 'cdbaf', ]
        ));
    }

    public function testFindMappingCandidates()
    {
        $expected = [
            'a' => ['c','f',],
            'b' => ['c','f',],
            'c' => ['e','g',],
            'd' => ['a',],
            'e' => ['b','d',],
            'f' => ['b','d',],
            'g' => ['e','g',],
        ];
        $candidates = $this->answer->findMappingCandidates(
            ['acedgfb', 'cdfbe', 'gcdfa', 'fbcad', 'dab', 'cefabd', 'cdfgeb', 'eafb', 'cagedb', 'ab','cdfeb', 'fcadb', 'cdfeb', 'cdbaf', ]
        );
        $this->assertEquals($expected, $candidates);
    }

    /**
     * @param $mapping
     * @param $signals
     * @param $outputs
     * @param $digits
     * @param $expected
     * @dataProvider dataForFindMapping
     */
    public function testFindMapping($mapping, $signals, $outputs, $digits, $expected)
    {
        $result = $this->answer->findMapping($mapping, $signals, $outputs, $digits);
        $this->assertEquals($expected, $result);
    }

    public function dataForFindMapping()
    {
        return [
            [[], [], [], [], 0],
            [['a' => 'b', 'b' => 'a'], ['ab', 'ba'], ['ab', 'ba'], ['abc', 'ab'], 11],
            [['a' => ['b', 'c'], 'b' => 'a', 'c' => ['b', 'a']], ['cb', 'ba'], ['cb', 'bc'], ['ac', 'ab'], 11],
        ];
    }
}
