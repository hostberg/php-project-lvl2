<?php

namespace Differ\Differ;

use function Differ\Parsers\parseFile;

function genDiff(string $file1Path, string $file2Path): string
{
    $file1 = parseFile(realpath($file1Path));
    $file2 = parseFile(realpath($file2Path));

    $equalRecords = array_intersect($file1, $file2);
    $removedRecords = array_diff_assoc($file1, $file2);
    $addedRecords = array_diff_assoc($file2, $file1);
    $allRecords = array_merge($file1, $file2);
    ksort($allRecords);

    $result = "{\n";

    foreach ($allRecords as $param => $value) {
        if (array_key_exists($param, $equalRecords)) {
            $result .= "  ${param}: $equalRecords[$param]\n";
        }

        if (array_key_exists($param, $removedRecords)) {
            $result .= "- ${param}: $removedRecords[$param]\n";
        }

        if (array_key_exists($param, $addedRecords)) {
            $result .= "+ ${param}: $addedRecords[$param]\n";
        }
    }

    $result .= "}\n";

    return $result;
}
