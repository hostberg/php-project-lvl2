<?php

namespace Differ\Differ;

use function Differ\Parser\parseFile;
use function Differ\Data\getDiff;
use function Differ\Formatter\Formatter\formatData;

function genDiff(string $file1Path, string $file2Path, string $format = 'stylish'): string
{
    $data = getDiff(parseFile($file1Path), parseFile($file2Path));
    return formatData($data, $format);
}
