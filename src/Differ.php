<?php

namespace Differ\Differ;

use function Differ\Parser\parseFile;
use function Differ\Data\getDiff;
use function Differ\Formatter\Formatter\formatData;

function genDiff(string $file1Path, string $file2Path, string $format = 'stylish'): string
{
    $file1RealPath = realpath($file1Path);
    $file2RealPath = realpath($file2Path);
    $file1Data = is_string($file1RealPath) ? parseFile($file1RealPath) : '';
    $file2Data = is_string($file2RealPath) ? parseFile($file2RealPath) : '';
    $data = getDiff($file1Data, $file2Data);
    return formatData($data, $format);
}
