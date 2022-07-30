<?php

namespace Differ\Differ;

use function Differ\Parser\parseFile;
use function Differ\Formatter\Formatter\formatData;
use function Functional\sort;

function genDiff(string $file1Path, string $file2Path, string $format = 'stylish'): string
{
    $data = getDiff(parseFile($file1Path), parseFile($file2Path));
    return formatData($data, $format);
}

function getDiff(array $data1, array $data2): array
{
    $mergedNodeNames = array_merge(array_keys($data1), array_keys($data2));
    $uniqNodeNames = array_unique($mergedNodeNames);
    $nodeNames = sort($uniqNodeNames, fn ($left, $right) => $left <=> $right);

    return array_map(function ($nodeName) use ($data1, $data2) {
        if (!array_key_exists($nodeName, $data1)) {
            $node = [
                'name' => $nodeName,
                'value' => $data2[$nodeName],
                'status' => 'added'
            ];
        } elseif (!array_key_exists($nodeName, $data2)) {
            $node = [
                'name' => $nodeName,
                'value' => $data1[$nodeName],
                'status' => 'deleted'
            ];
        } elseif ($data1[$nodeName] === $data2[$nodeName]) {
            $node = [
                'name' => $nodeName,
                'value' => $data2[$nodeName],
                'status' => 'unchanged'
            ];
        } elseif (is_array($data1[$nodeName]) && is_array($data2[$nodeName])) {
            $children = getDiff($data1[$nodeName], $data2[$nodeName]);
            $node = [
                'name' => $nodeName,
                'children' => $children,
                'status' => 'nested'
            ];
        } else {
            $node = [
                'name' => $nodeName,
                'oldValue' => $data1[$nodeName],
                'newValue' => $data2[$nodeName],
                'status' => 'changed'];
        }
        return $node;
    }, $nodeNames);
}
