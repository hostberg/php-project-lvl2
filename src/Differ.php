<?php

namespace Differ\Differ;

use function Differ\Parsers\parseFile;
use function Differ\Data\getDiff;

function genDiff(string $file1Path, string $file2Path): void
{
//    $file1Data = genData(parseFile(realpath($file1Path)));
//    $file2Data = genData(parseFile(realpath($file2Path)));

    $file1Data = parseFile(realpath($file1Path));
    $file2Data = parseFile(realpath($file2Path));

    print_r(getDiff($file1Data, $file2Data));
}
