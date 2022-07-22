<?php

namespace Differ\Tests\Formatter;

use PHPUnit\Framework\TestCase;

use function Differ\Parser\parseFile;
use function Differ\Data\getDiff;
use function Differ\Formatter\Stylish\formatStylish;

const STYLISH_EXPECTED_DATA = '{
    common: {
      + follow: false
        setting1: Value 1
      - setting2: 200
      - setting3: true
      + setting3: null
      + setting4: blah blah
      + setting5: {
            key5: value5
        }
        setting6: {
            doge: {
              - wow: 
              + wow: so much
            }
            key: value
          + ops: vops
        }
    }
    group1: {
      - baz: bas
      + baz: bars
        foo: bar
      - nest: {
            key: value
        }
      + nest: str
    }
  - group2: {
        abc: 12345
        deep: {
            id: 45
        }
    }
  + group3: {
        deep: {
            id: {
                number: 45
            }
        }
        fee: 100500
    }
}';

class StylishTest extends TestCase
{
    private function getFixturePath(string $file): string
    {
        return realpath('./tests/fixtures/' . $file);
    }

    public function testGetLines(): void
    {
        $file1Data = parseFile($this->getFixturePath('file1.json'));
        $file2Data = parseFile($this->getFixturePath('file2.json'));
        $data = getDiff($file1Data, $file2Data);
        $this->assertEquals(STYLISH_EXPECTED_DATA, formatStylish($data));

        $file1Data = parseFile($this->getFixturePath('file1.yml'));
        $file2Data = parseFile($this->getFixturePath('file2.yml'));
        $data = getDiff($file1Data, $file2Data);
        $this->assertEquals(STYLISH_EXPECTED_DATA, formatStylish($data));
    }
}
