<?php

namespace Differ\Formatter\Plain;

function stringify(mixed $value): string
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
                $value = stringify($node['value']);
                $line = 'Property \'' . $property . '\' was added with value: ' . $value;
                break;
            case 'deleted':
                $line = 'Property \'' . $property . '\' was removed';
                break;
            case 'changed':
                $oldValue = stringify($node['oldValue']);
                $newValue = stringify($node['newValue']);
                $line = 'Property \'' . $property . '\' was updated. From ' . $oldValue . ' to ' . $newValue;
                break;
            default:
                $line = null;
        }
        return $line;
    }, $data);

    return implode("\n", array_filter($result));
}
