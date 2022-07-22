<?php

namespace Differ\Formatter\Plain;

function getValue($value): string
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

function formatPlain(array $data, bool $returnString = true, string $path = ''): array|string
{
    $result = array_reduce(array_keys($data), function ($lines, $node) use ($data, $path) {
        switch ($data[$node]['status']) {
            case 'nested':
                $path .= $node . '.';
                $nestedLines = formatPlain($data[$node]['children'], false, $path);
                $lines = array_merge($lines, $nestedLines);
                break;
            case 'added':
                $lines[] = 'Property \'' . $path . $node . '\' was added with value: ' . getValue($data[$node]['value']);
                break;
            case 'deleted':
                $lines[] = 'Property \'' . $path . $node . '\' was removed';
                break;
            case 'changed':
                $lines[] = 'Property \'' . $path . $node . '\' was updated. From ' . getValue($data[$node]['oldValue']) . ' to ' . getValue($data[$node]['newValue']);
                break;
            default:
                break;
        }
        return $lines;
    }, []);
    return $returnString ? implode("\n", $result) : $result;
}
