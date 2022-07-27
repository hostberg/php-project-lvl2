<?php

namespace Differ\Parser;

use Symfony\Component\Yaml\Yaml;

function parseFile(string $filePath): array
{
    $fileData = file_get_contents($filePath);
    if (!$fileData) {
        return 'No input data';
    }
    $fileExtension = isset(pathinfo($filePath)['extension']) ? pathinfo($filePath)['extension'] : '';
    return match ($fileExtension) {
        'json' => json_decode($fileData, true),
        'yml', 'yaml' => Yaml::parse($fileData),
        default => ['Unknown file format' => $fileExtension],
    };
}
