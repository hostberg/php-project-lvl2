<?php

namespace Differ\Tests;

use PHPUnit\Framework\TestCase;

use function Differ\Differ\genDiff;
use function Differ\Parser\parseFile;
use function Differ\Data\getDiff;
use function Differ\Formatter\Stylish\formatStylish;

class DifferTest extends TestCase
{
    private function getFixturePath(string $file): string
    {
        return realpath('./tests/fixtures/' . $file);
    }

    private function getFixtureValue(string $file): string
    {
        return file_get_contents('./tests/fixtures/' . $file);
    }

//    protected function setUp(): void
//    {
//        parent::setUp(); // TODO: Change the autogenerated stub
//        $file1DataJson = parseFile($this->getFixturePath('file1.json'));
//        $file2DataJson = parseFile($this->getFixturePath('file2.json'));
//        $file1DataYml = parseFile($this->getFixturePath('file1.yml'));
//        $file2DataYml = parseFile($this->getFixturePath('file2.yml'));
//        $this->$dataJson = getDiff($file1DataJson, $file2DataJson);
//        $this->$dataYml = getDiff($file1DataYml, $file2DataYml);
//        $dataStylish = $this->getFixtureValue('expected_stylish.txt');
//    }

    public function testGenDiff(): void
    {
        $file1DataJson = $this->getFixturePath('file1.json');
        $file2DataJson = $this->getFixturePath('file2.json');
        $file1DataYml = $this->getFixturePath('file1.yml');
        $file2DataYml = $this->getFixturePath('file2.yml');
        $dataStylish = $this->getFixtureValue('expected_stylish.txt');
        $dataPlain = $this->getFixtureValue('expected_plain.txt');

        $this->assertEquals($dataStylish, genDiff($file1DataJson, $file2DataJson, 'stylish'));
        $this->assertEquals($dataStylish, genDiff($file1DataYml, $file2DataYml, 'stylish'));
        $this->assertEquals($dataPlain, genDiff($file1DataJson, $file2DataJson, 'plain'));
        $this->assertEquals($dataPlain, genDiff($file1DataYml, $file2DataYml, 'plain'));
    }
}