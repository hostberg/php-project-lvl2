<?php

namespace Differ\Differ;

use function Differ\Parser\parseFile;
use function Differ\Data\getDiff;
use function Differ\Formatter\Formatter\formatData;

function genDiff(string $file1Path, string $file2Path, string $format = 'stylish'): string
{
    $file1RealPath = realpath($file1Path);
    $file2RealPath = realpath($file2Path);
    if (!is_string($file1RealPath) || !is_string($file2RealPath)) {
        return 'Can\'t get access to file[s] ';
    }
    $file1Data = parseFile($file1RealPath);
    $file2Data = parseFile($file2RealPath);
    $data = getDiff($file1Data, $file2Data);
    return formatData($data, $format);
}
