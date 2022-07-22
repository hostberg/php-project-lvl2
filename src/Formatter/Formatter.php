<?php

namespace Differ\Formatter\Formatter;

use function Differ\Formatter\Stylish\formatStylish;

function formatData(array $data, string $format): string
{
    return match ($format) {
        'stylish' => formatStylish($data),
        default => "Unknown format style: ${format}",
    };
}
