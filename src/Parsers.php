<?php

namespace Differ\Parsers;

use Symfony\Component\Yaml\Yaml;

function getFileExtension(string $filePath): string
{
    return pathinfo($filePath)['extension'];
}

function parseFile(string $filePath): array
{
    $fileData = file_get_contents($filePath);
    return match (getFileExtension($filePath)) {
        'json' => json_decode($fileData, true),
        'yml', 'yaml' => (array)Yaml::parse($fileData, Yaml::PARSE_OBJECT_FOR_MAP),
        default => ['unknown file format'],
    };
}
