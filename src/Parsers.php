<?php

namespace Differ\Parsers;

function getFileExtension(string $filePath): string
{
    return pathinfo($filePath)['extension'];
}

function parseFile(string $filePath): array
{
    $fileData = file_get_contents($filePath);
    return match (getFileExtension($filePath)) {
        'json' => json_decode($fileData, true),
        'yml', 'yaml' => ['yml file'],
        default => ['unknown file format'],
    };
}
