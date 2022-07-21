<?php

namespace Differ\Tests\Parser;

use PHPUnit\Framework\TestCase;

use function Differ\Parser\parseFile;

const EXPECTED_DATA = [
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
        $this->assertEquals(EXPECTED_DATA, parseFile($this->getFixturePath('simple_file.json')));
        $this->assertEquals(EXPECTED_DATA, parseFile($this->getFixturePath('simple_file.yaml')));
    }
}
