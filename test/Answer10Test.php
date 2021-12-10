<?php

namespace AdventOfCode;

class Answer10Test extends BaseTest
{
    /**
     * @var Answer10
     */
    protected $answer;

    public function setUp(): void
    {
        parent::setUp();
        $this->answer = new Answer10($this->logger);
    }

    /**
     * @dataProvider dataForFirstIllegalCharacter
     */
    public function testGetFirstIllegalCharacter($line, $result)
    {
        $this->assertEquals($result, $this->answer->findFirstIllegalCharacter($line));
    }

    public function dataForFirstIllegalCharacter()
    {
        return [
            ['[]', []],
            ['([])', []],
            ['{()()()}', []],
            ['<([{}])>', []],
            ['[<>({}){}[([])<>]]', []],
            ['(((((((((())))))))))', []],
            ['{([(<{}[<>[]}>{[]{[(<()>', '}'],
            ['[[<[([]))<([[{}[[()]]]', ')'],
            ['[{[{({}]{}}([{[{{{}}([]', ']'],
            ['[<(<(<(<{}))><([]([]()', ')'],
            ['<{([([[(<>()){}]>(<<{{', '>'],
        ];
    }

    public function testOne()
    {
        $input = [
            '{([(<{}[<>[]}>{[]{[(<()>',
            '[[<[([]))<([[{}[[()]]]',
            '[{[{({}]{}}([{[{{{}}([]',
            '[<(<(<(<{}))><([]([]()',
            '<{([([[(<>()){}]>(<<{{',
        ];
        $this->assertEquals(26397, $this->answer->one($input));
    }

    /**
     * @param $line
     * @param $completion
     * @dataProvider dataForCompleteLines
     */
    public function testCompleteLines($line, $completion)
    {
        $completionChars = str_split($completion);
        $this->assertEquals($completionChars, $this->answer->findFirstIllegalCharacter($line));
    }

    public function dataForCompleteLines()
    {
        return [
            ['[({(<(())[]>[[{[]{<()<>>', '}}]])})]'],
            ['[(()[<>])]({[<{<<[]>>(', ')}>]})'],
            ['(((({<>}<{<{<>}{[]{[]{}', '}}>}>))))'],
            ['{<[[]]>}<{[{[{[]{()[[[]', ']]}}]}]}>'],
            ['<{([{{}}[<[[[<>{}]]]>[]]', '])}>'],
        ];
    }

    public function testTwo()
    {
        $input = [
            '[({(<(())[]>[[{[]{<()<>>',
            '[(()[<>])]({[<{<<[]>>(',
            '(((({<>}<{<{<>}{[]{[]{}',
            '{<[[]]>}<{[{[{[]{()[[[]',
            '<{([{{}}[<[[[<>{}]]]>[]]',
        ];
        $this->assertEquals(288957, $this->answer->two($input));
    }
}
