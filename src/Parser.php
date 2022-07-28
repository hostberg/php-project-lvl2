<?php

namespace Differ\Parser;

use Symfony\Component\Yaml\Yaml;

function parseFile(string $filePath): array
{
    $fileRealPath = realpath($filePath) ?? '';
    $fileData = file_get_contents($fileRealPath) ?? '';
    if (empty($fileData)) {
        throw new \Exception("Can't parse data from file: ${filePath}");
    }
    $fileExtension = pathinfo($filePath)['extension'] ?? null;
    return match ($fileExtension) {
        'json' => parseData($fileData, 'json'),
        'yml', 'yaml' => parseData($fileData, 'yml'),
        default => throw new \Exception("Unknown data format: ${fileExtension}"),
    };
}

function parseData(string $data, string $format): array
{
    return match ($format) {
        'json' => json_decode($data, true),
        'yml' => Yaml::parse($data),
        default => throw new \Exception("Unknown data format: ${format}"),
    };
}
