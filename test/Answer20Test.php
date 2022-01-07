<?php

namespace AdventOfCode;

class Answer20Test extends BaseTest
{
    /**
     * @var Answer20
     */
    protected $answer;

    public function setUp(): void
    {
        parent::setUp();
        $this->answer = new Answer20($this->logger);
    }

    public function testOutputIndex()
    {
        $grid = [
            '#..#.',
            '#....',
            '##..#',
            '..#..',
            '..###'
        ];
        $grid = $this->answer->parseGrid($grid);
        $this->assertEquals(34, $this->answer->getOutputIndex($grid, [2, 2]));
    }

    public function testMapPixel()
    {
        $grid = [
            '#..#.',
            '#....',
            '##..#',
            '..#..',
            '..###'
        ];
        $grid = $this->answer->parseGrid($grid);
        $algorithm = '..#.#..#####.#.#.#.###.##.....###.##.#..###.####..#####..#....#..#..##..###..######.###...####..#..#####..##..#.#####...##.#.#..#.##..#.#......#.###.######.###.####...#.##.##..#..#..#####.....#.#....###..#.##......#.....#..#..#..##..#...##.######.####.####.#.#...#.......#..#.#.#...####.##.#......#..#...##.#.##..#...##.#.##..###.#......#.#.......#.#.#.####.###.##...#.....####.#..#..#.##.#....##..#.####....##...##..#...#......#.#.......#.......##..####..#...#.#.#...##..#.#..###..#####........#..####......#..#';
        $this->assertEquals('#', $this->answer->getMappedPixel($grid, $algorithm, [2, 2]));
    }

    public function testApplyAlgorithm()
    {
        $grid = [
            '...............',
            '...............',
            '...............',
            '...............',
            '...............',
            '.....#..#......',
            '.....#.........',
            '.....##..#.....',
            '.......#.......',
            '.......###.....',
            '...............',
            '...............',
            '...............',
            '...............',
            '...............'
        ];
        $grid = $this->answer->parseGrid($grid);
        $algorithm = '..#.#..#####.#.#.#.###.##.....###.##.#..###.####..#####..#....#..#..##..###..######.###...####..#..#####..##..#.#####...##.#.#..#.##..#.#......#.###.######.###.####...#.##.##..#..#..#####.....#.#....###..#.##......#.....#..#..#..##..#...##.######.####.####.#.#...#.......#..#.#.#...####.##.#......#..#...##.#.##..#...##.#.##..###.#......#.#.......#.#.#.####.###.##...#.....####.#..#..#.##.#....##..#.####....##...##..#...#......#.#.......#.......##..####..#...#.#.#...##..#.#..###..#####........#..####......#..#';
        $expected = [
            '.........',
            '..##.##..',
            '.#..#.#..',
            '.##.#..#.',
            '.####..#.',
            '..#..##..',
            '...##..#.',
            '....#.#..',
            '.........'
        ];
        $output = $this->answer->applyAlgorithm($grid, $algorithm);
        $output = array_values(array_map(function ($line) {
            return implode($line);
        }, $output));
        $this->assertEquals($expected, $output);
    }

    public function testOne() {
        $input = [
            '..#.#..#####.#.#.#.###.##.....###.##.#..###.####..#####..#....#..#..##..###..######.###...####..#..#####..##..#.#####...##.#.#..#.##..#.#......#.###.######.###.####...#.##.##..#..#..#####.....#.#....###..#.##......#.....#..#..#..##..#...##.######.####.####.#.#...#.......#..#.#.#...####.##.#......#..#...##.#.##..#...##.#.##..###.#......#.#.......#.#.#.####.###.##...#.....####.#..#..#.##.#....##..#.####....##...##..#...#......#.#.......#.......##..####..#...#.#.#...##..#.#..###..#####........#..####......#..#',
            '',
            '#..#.',
            '#....',
            '##..#',
            '..#..',
            '..###'
        ];
        $this->assertEquals(35, $this->answer->one($input));
    }

    /**
     * @group slow
     */
    public function testTwo() {
        $input = [
            '..#.#..#####.#.#.#.###.##.....###.##.#..###.####..#####..#....#..#..##..###..######.###...####..#..#####..##..#.#####...##.#.#..#.##..#.#......#.###.######.###.####...#.##.##..#..#..#####.....#.#....###..#.##......#.....#..#..#..##..#...##.######.####.####.#.#...#.......#..#.#.#...####.##.#......#..#...##.#.##..#...##.#.##..###.#......#.#.......#.#.#.####.###.##...#.....####.#..#..#.##.#....##..#.####....##...##..#...#......#.#.......#.......##..####..#...#.#.#...##..#.#..###..#####........#..####......#..#',
            '',
            '#..#.',
            '#....',
            '##..#',
            '..#..',
            '..###'
        ];
        $this->assertEquals(3351, $this->answer->two($input));
    }
}
