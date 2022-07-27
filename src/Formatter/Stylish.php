<?php

namespace Differ\Formatter\Stylish;

function getValue(mixed $value, string $indent = ''): string
{
    if (is_array($value)) {
        $arrayValue = array_map(function ($nodeValue, $nodeName) use ($indent) {
            $indent .= '    ';
            return $indent . $nodeName . ': ' . getValue($nodeValue, $indent);
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
                $line = $linePrefix . $node['name'] . ': ' . getValue($node['value'], $indent);
                break;
            case 'deleted':
                $linePrefix = substr($indent, 0, -2) . '- ';
                $line = $linePrefix . $node['name'] . ': ' . getValue($node['value'], $indent);
                break;
            case 'unchanged':
                $linePrefix = substr($indent, 0, -2) . '  ';
                $line = $linePrefix . $node['name'] . ': ' . getValue($node['value'], $indent);
                break;
            case 'changed':
                $linePrefix = substr($indent, 0, -2) . '- ';
                $line = $linePrefix . $node['name'] . ': ' . getValue($node['oldValue'], $indent);
                $linePrefix = substr($indent, 0, -2) . '+ ';
                $line .= "\n" . $linePrefix . $node['name'] . ': ' . getValue($node['newValue'], $indent);
                break;
            default:
                $line = '';
        }
        return $line;
    }, $data);

    return "{\n" . implode("\n", $result) . "\n" . substr($indent, 0, -4) . "}";
}

//function formatStylish(array $data, string $indent = '    '): string
//{
//    $result = array_reduce(array_keys($data), function ($lines, $node) use ($data, $indent) {
//        switch ($data[$node]['status']) {
//            case 'nested':
//                $linePrefix = substr($indent, 0, -2) . '  ';
//                $lines[] = $linePrefix . $node . ': ' . formatStylish($data[$node]['children'], $indent . '    ');
//                break;
//            case 'added':
//                $linePrefix = substr($indent, 0, -2) . '+ ';
//                $lines[] = $linePrefix . $node . ': ' . getValue($data[$node]['value'], $indent);
//                break;
//            case 'deleted':
//                $linePrefix = substr($indent, 0, -2) . '- ';
//                $lines[] = $linePrefix . $node . ': ' . getValue($data[$node]['value'], $indent);
//                break;
//            case 'unchanged':
//                $linePrefix = substr($indent, 0, -2) . '  ';
//                $lines[] = $linePrefix . $node . ': ' . getValue($data[$node]['value'], $indent);
//                break;
//            case 'changed':
//                $linePrefix = substr($indent, 0, -2) . '- ';
//                $lines[] = $linePrefix . $node . ': ' . getValue($data[$node]['oldValue'], $indent);
//                $linePrefix = substr($indent, 0, -2) . '+ ';
//                $lines[] = $linePrefix . $node . ': ' . getValue($data[$node]['newValue'], $indent);
//                break;
//            default:
//                break;
//        }
//        return $lines;
//    }, []);
//    return "{\n" . implode("\n", $result) . "\n" . substr($indent, 0, -4) . "}";
//}
