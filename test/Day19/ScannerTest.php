<?php

namespace AdventOfCode\Day19;

use PHPUnit\Framework\TestCase;

class ScannerTest extends TestCase
{

    public function testCreateScanner()
    {
        $scanner = Scanner::create('--- scanner 111 ---');
        $this->assertInstanceOf('AdventOfCode\Day19\Scanner', $scanner);
        $this->assertEquals(111, $scanner->getId());
    }
}
