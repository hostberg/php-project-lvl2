<?php

namespace Differ\Differ;

use function Differ\Parser\parseFile;
use function Differ\Data\getDiff;
use function Differ\Formatter\Formatter\formatData;

function genDiff(string $file1Path, string $file2Path, string $format = 'stylish'): string
{
    $file1Data = parseFile(realpath($file1Path));
    $file2Data = parseFile(realpath($file2Path));
    $data = getDiff($file1Data, $file2Data);
//    var_dump($data);
    return formatData($data, $format);
}
