<?php

namespace Differ\Formatter\Json;

function formatJson(array $data): string
{
    return json_encode($data, JSON_PRETTY_PRINT);
}
