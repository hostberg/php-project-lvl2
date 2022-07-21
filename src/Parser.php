<?php

namespace Differ\Parser;

use Symfony\Component\Yaml\Yaml;

function parseFile(string $filePath): array
{
    $fileData = file_get_contents($filePath);
    $fileExtension = pathinfo($filePath)['extension'];
    return match ($fileExtension) {
        'json' => json_decode($fileData, true),
        'yml', 'yaml' => Yaml::parse($fileData),
        default => throw new InvalidStatusCodeException('unknown file format'),
    };
}
