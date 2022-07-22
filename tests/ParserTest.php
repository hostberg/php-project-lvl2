<?php

namespace Differ\Tests;

use PHPUnit\Framework\TestCase;

use function Differ\Parser\parseFile;

const PARSER_EXPECTED_DATA = [
    'data1' => [
        'key1' => 'value 1',
        'data2' => [
            'key2' => 'value 2'
        ]
    ]
];

class ParserTest extends TestCase
{
    private function getFixturePath(string $file): string
    {
        return realpath('./tests/fixtures/' . $file);
    }

    public function testParseFile(): void
    {
        $this->assertEquals(PARSER_EXPECTED_DATA, parseFile($this->getFixturePath('simple_file.json')));
        $this->assertEquals(PARSER_EXPECTED_DATA, parseFile($this->getFixturePath('simple_file.yaml')));
    }
}
