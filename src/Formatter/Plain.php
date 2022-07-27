<?php

namespace Differ\Formatter\Plain;

function getValue(mixed $value): string
{
    if (is_array($value)) {
        $result = '[complex value]';
    } elseif (is_string($value)) {
        $result = '\'' . $value . '\'';
    } else {
        $result = json_encode($value);
    }
    return $result;
}

function formatPlain(array $data, string $path = ''): string
{
    $result = array_map(function ($node) use ($path) {
        $property = $path . $node['name'];
        switch ($node['status']) {
            case 'nested':
                $nestedPath = $path . $node['name'] . '.';
                $line = formatPlain($node['children'], $nestedPath);
                break;
            case 'added':
                $value = getValue($node['value']);
                $line = "Property '${property}' was added with value: ${value}";
                break;
            case 'deleted':
                $line = "Property '${property}' was removed";
                break;
            case 'changed':
                $oldValue = getValue($node['oldValue']);
                $newValue = getValue($node['newValue']);
                $line = "Property '${property}' was updated. From ${oldValue} to ${newValue}";
                break;
            default:
                $line = [];
        }
        return $line;
    }, $data);

    return implode("\n", array_filter($result));
}


//function formatPlain(array $data, bool $returnString = true, string $path = ''): array|string
//{
//    $result = array_reduce(array_keys($data), function ($lines, $node) use ($data, $path) {
//        switch ($data[$node]['status']) {
//            case 'nested':
//                $path .= $node . '.';
//                $nestedLines = formatPlain($data[$node]['children'], false, $path);
//                $lines = array_merge($lines, $nestedLines);
//                break;
//            case 'added':
//                $lines[] = 'Property \'' . $path . $node . '\' was added with value: '
// . getValue($data[$node]['value']);
//                break;
//            case 'deleted':
//                $lines[] = 'Property \'' . $path . $node . '\' was removed';
//                break;
//            case 'changed':
//                $lines[] = 'Property \'' . $path . $node . '\' was updated. From '
// . getValue($data[$node]['oldValue']) . ' to ' . getValue($data[$node]['newValue']);
//                break;
//            default:
//                break;
//        }
//        return $lines;
//    }, []);
//    return $returnString ? implode("\n", $result) : $result;
//}
