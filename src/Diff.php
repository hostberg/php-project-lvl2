<?php

namespace Differ\Diff;

function genDiff(string $pathToFile1, string $pathToFile2): string
{
    $file1 = json_decode(file_get_contents($pathToFile1), true);
    $file2 = json_decode(file_get_contents($pathToFile2), true);

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
