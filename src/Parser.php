<?php

namespace Differ\Parser;

use Symfony\Component\Yaml\Yaml;

function parseFile(string $filePath): array
{
    $fileRealPath = realpath($filePath) ?? throw new \Exception("Can't find file: ". $filePath);
    $fileData = file_get_contents($fileRealPath) ?? throw new \Exception("Can't access file: ". $filePath);
//    if ($fileData === false) {
//        return 'No input data';
//    }
//    $fileExtension = isset(pathinfo($filePath)['extension']) ? pathinfo($filePath)['extension'] : '';
    $fileExtension = pathinfo($filePath)['extension'] ?? null;
    return match ($fileExtension) {
        'json' => json_decode($fileData, true),
        'yml', 'yaml' => Yaml::parse($fileData),
        default => throw new \Exception("Unknown data format: ${$fileExtension}"),
    };
}

function parseData(array $data, string $format): array
{
    return match ($format) {
        'json' => json_decode($data, true),
        'yml', 'yaml' => Yaml::parse($data),
        default => throw new \Exception("Unknown data format: ${$format}"),
    };
}
