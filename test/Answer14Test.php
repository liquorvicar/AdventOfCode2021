<?php

namespace AdventOfCode;

class Answer14Test extends BaseTest
{
    /**
     * @var Answer14
     */
    protected $answer;

    public function setUp(): void
    {
        parent::setUp();
        $this->answer = new Answer14($this->logger);
    }

    /**
     * @param $output
     * @param $steps
     * @dataProvider dataForProcessSteps
     */
    public function testMultipleSteps($output, $steps)
    {
        $template = 'NNCB';
        $rules = [
            'CH' => 'B',
            'HH' => 'N',
            'CB' => 'H',
            'NH' => 'C',
            'HB' => 'C',
            'HC' => 'B',
            'HN' => 'C',
            'NN' => 'C',
            'BH' => 'H',
            'NC' => 'B',
            'NB' => 'B',
            'BN' => 'B',
            'BB' => 'N',
            'BC' => 'B',
            'CC' => 'N',
            'CN' => 'C',
        ];
        while ($steps > 0) {
            $template = $this->answer->processStep($template, $rules);
            $steps--;
        }
        $this->assertEquals($output, $template);
    }


    public function dataForProcessSteps()
    {
        return [
            ['NCNBCHB', 1],
            ['NBCCNBBBCBHCB', 2],
            ['NBBBCNCCNBBNBNBBCHBHHBCHB', 3],
            ['NBBNBNBBCCNBCNCCNBBNBBNBBBNBBNBBCBHCBHHNHCBBCBHCB', 4],
        ];
    }

    public function testOne()
    {
        $input = [
            'NNCB',
            '',
            'CH -> B',
            'HH -> N',
            'CB -> H',
            'NH -> C',
            'HB -> C',
            'HC -> B',
            'HN -> C',
            'NN -> C',
            'BH -> H',
            'NC -> B',
            'NB -> B',
            'BN -> B',
            'BB -> N',
            'BC -> B',
            'CC -> N',
            'CN -> C',
        ];
        $this->assertEquals(1588, $this->answer->one($input));
    }

    public function testTwo()
    {
        $input = [
            'NNCB',
            '',
            'CH -> B',
            'HH -> N',
            'CB -> H',
            'NH -> C',
            'HB -> C',
            'HC -> B',
            'HN -> C',
            'NN -> C',
            'BH -> H',
            'NC -> B',
            'NB -> B',
            'BN -> B',
            'BB -> N',
            'BC -> B',
            'CC -> N',
            'CN -> C',
        ];
        $this->assertEquals(2188189693529, $this->answer->two($input));
    }
}
