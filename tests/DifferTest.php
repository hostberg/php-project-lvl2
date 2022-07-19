<?php declare(strict_types=1);

namespace Differ\Tests;

use PHPUnit\Framework\TestCase;

use function Differ\Differ\genDiff;

class DifferTest extends TestCase
{
    public function testDiffer(): void
    {
        $correctDiff = "{
- follow: 
  host: hexlet.io
- proxy: 123.234.53.22
- timeout: 50
+ timeout: 20
+ verbose: 1
}
";
        $resultDiff = genDiff('./tests/fixtures/file1.json', './tests/fixtures/file2.json');
        $this->assertEquals($correctDiff, $resultDiff);
        $resultDiff = genDiff('./tests/fixtures/file1.yml', './tests/fixtures/file2.yml');
        $this->assertEquals($correctDiff, $resultDiff);
    }
}
