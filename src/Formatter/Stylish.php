<?php

namespace Differ\Formatter\Stylish;

function stringify(mixed $value, string $indent = ''): string
{
    if (is_array($value)) {
        $arrayValue = array_map(function ($nodeValue, $nodeName) use ($indent) {
            $nestedIndent = $indent . '    ';
            return $nestedIndent . $nodeName . ': ' . stringify($nodeValue, $nestedIndent);
        }, $value, array_keys($value));
        $result = "{\n" . implode("\n", $arrayValue) . "\n" . $indent . "}";
    } elseif (is_string($value)) {
        $result = $value;
    } else {
        $result = json_encode($value);
    }
    return $result;
}

function formatStylish(array $data, string $indent = '    '): string
{
    $result = array_map(function ($node) use ($indent) {
        switch ($node['status']) {
            case 'nested':
                $linePrefix = substr($indent, 0, -2) . '  ';
                $line = $linePrefix . $node['name'] . ': ' . formatStylish($node['children'], $indent . '    ');
                break;
            case 'added':
                $linePrefix = substr($indent, 0, -2) . '+ ';
                $line = $linePrefix . $node['name'] . ': ' . stringify($node['value'], $indent);
                break;
            case 'deleted':
                $linePrefix = substr($indent, 0, -2) . '- ';
                $line = $linePrefix . $node['name'] . ': ' . stringify($node['value'], $indent);
                break;
            case 'unchanged':
                $linePrefix = substr($indent, 0, -2) . '  ';
                $line = $linePrefix . $node['name'] . ': ' . stringify($node['value'], $indent);
                break;
            case 'changed':
                $oldLinePrefix = substr($indent, 0, -2) . '- ';
                $oldLine = $oldLinePrefix . $node['name'] . ': ' . stringify($node['oldValue'], $indent);
                $newLinePrefix = substr($indent, 0, -2) . '+ ';
                $newline = $newLinePrefix . $node['name'] . ': ' . stringify($node['newValue'], $indent);
                $line = $oldLine . "\n" . $newline;
                break;
            default:
                $line = '';
        }
        return $line;
    }, $data);

    return "{\n" . implode("\n", $result) . "\n" . substr($indent, 0, -4) . "}";
}
