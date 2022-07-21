<?php

namespace Differ\Differ;

use function Differ\Parser\parseFile;
use function Differ\Data\getDiff;

function genDiff(string $file1Path, string $file2Path): void
{
    $file1Data = parseFile(realpath($file1Path));
    $file2Data = parseFile(realpath($file2Path));
}
