<?php

namespace Differ\Formatter\Stylish;

function getIndent(int $depth, ?string $flag = null): string
{
    $step = '    ';
    $indent = str_repeat($step, $depth);
    return isset($flag) ? substr($indent, 0, -2) . $flag . ' ' : $indent;
}

function stringify(mixed $value, int $depth = 1): string
{
    if (is_array($value)) {
        $arrayValue = array_map(function ($nodeValue, $nodeName) use ($depth) {
            return getIndent($depth + 1) . $nodeName . ': ' . stringify($nodeValue, $depth + 1);
        }, $value, array_keys($value));
        $resultPrefix = "{\n";
        $resultPostfix = "\n" . getIndent($depth) . "}";
        $result = $resultPrefix . implode("\n", $arrayValue) . $resultPostfix;
    } elseif (is_string($value)) {
        $result = $value;
    } else {
        $result = json_encode($value);
    }
    return $result;
}

function formatStylish(array $data, int $depth = 1): string
{
    $result = array_map(function ($node) use ($depth) {
        switch ($node['status']) {
            case 'nested':
                $linePrefix = getIndent($depth);
                $line = $linePrefix . $node['name'] . ': ' . formatStylish($node['children'], $depth + 1);
                break;
            case 'added':
                $linePrefix = getIndent($depth, '+');
                $line = $linePrefix . $node['name'] . ': ' . stringify($node['value'], $depth);
                break;
            case 'deleted':
                $linePrefix = getIndent($depth, '-');
                $line = $linePrefix . $node['name'] . ': ' . stringify($node['value'], $depth);
                break;
            case 'unchanged':
                $linePrefix = getIndent($depth);
                $line = $linePrefix . $node['name'] . ': ' . stringify($node['value'], $depth);
                break;
            case 'changed':
                $oldLinePrefix = getIndent($depth, '-');
                $oldLine = $oldLinePrefix . $node['name'] . ': ' . stringify($node['oldValue'], $depth);
                $newLinePrefix = getIndent($depth, '+');
                $newline = $newLinePrefix . $node['name'] . ': ' . stringify($node['newValue'], $depth);
                $line = $oldLine . "\n" . $newline;
                break;
            default:
                $line = '';
        }
        return $line;
    }, $data);

    $resultPrefix = "{\n";
    $resultPostfix =  "\n" . substr(getIndent($depth), 0, -4) . "}";
    return $resultPrefix . implode("\n", $result) . $resultPostfix;
}
