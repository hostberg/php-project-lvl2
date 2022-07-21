<?php

namespace Differ\Tests\Differ;

use PHPUnit\Framework\TestCase;

use function Differ\Differ\genDiff;

class DifferTest extends TestCase
{
    private function getFixturePath(string $file): string
    {
        return realpath('./tests/fixtures/' . $file);
    }

    public function testGenDiff(): void
    {
        $this->assertEquals(null, null);
    }
}
