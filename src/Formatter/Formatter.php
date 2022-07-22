<?php

namespace Differ\Formatter\Formatter;

use function Differ\Formatter\Stylish\formatStylish;
use function Differ\Formatter\Plain\formatPlain;
use function Differ\Formatter\Json\formatJson;

function formatData(array $data, string $format): string
{
    return match ($format) {
        'stylish' => formatStylish($data),
        'plain' => formatPlain($data),
        'json' => formatJson($data),
        default => "Unknown format style: ${format}",
    };
}
