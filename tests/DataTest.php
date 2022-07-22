<?php

namespace Differ\Tests;

use PHPUnit\Framework\TestCase;

use function Differ\Parser\parseFile;
use function Differ\Data\getDiff;
use function Differ\Data\getNodeNames;

const DATA_EXPECTED_DATA = [
    'common' => [
        'children' => [
            'follow' => [
                'value' => false,
                'status' => 'added'
            ],
            'setting1' => [
                'value' => 'Value 1',
                'status' => 'unchanged'
            ],
            'setting2' => [
                'value' => 200,
                'status' => 'deleted'
            ],
            'setting3' => [
                'oldValue' => true,
                'newValue' => null,
                'status' => 'changed'
            ],
            'setting4' => [
                'value' => 'blah blah',
                'status' => 'added'
            ],
            'setting5' => [
                'value' => [
                    'key5' => 'value5'
                ],
                'status' => 'added'
            ],
            'setting6' => [
                'children' => [
                    'doge' => [
                        'children' => [
                            'wow' => [
                                'oldValue' => '',
                                'newValue' => 'so much',
                                'status' => 'changed'
                            ]
                        ],
                        'status' => 'nested'
                    ],
                    'key' => [
                        'value' => 'value',
                        'status' => 'unchanged'
                    ],
                    'ops' => [
                        'value' => 'vops',
                        'status' => 'added'
                    ]
                ],
                'status' => 'nested'
            ]
        ],
        'status' => 'nested'
    ],
    'group1' => [
        'children' => [
            'baz' => [
                'oldValue' => 'bas',
                'newValue' => 'bars',
                'status' => 'changed'
            ],
            'foo' => [
                'value' => 'bar',
                'status' => 'unchanged'
            ],
            'nest' => [
                'oldValue' => [
                    'key' => 'value'
                ],
                'newValue' => 'str',
                'status' => 'changed'
            ]
        ],
        'status' => 'nested'
    ],
    'group2' => [
        'value' => [
            'abc' => 12345,
            'deep' => [
                'id' => 45
            ]
        ],
        'status' => 'deleted'
    ],
    'group3' => [
        'value' => [
            'deep' => [
                'id' => [
                    'number' => 45
                ]
            ],
            'fee' => 100500
        ],
        'status' => 'added'
    ]
];

class DataTest extends TestCase
{
    private function getFixturePath(string $file): string
    {
        return realpath('./tests/fixtures/' . $file);
    }

    public function testGetNodeNames(): void
    {
        $data1 = [
            'three' => 'value',
            'two' => 'value',
            'one' => 'value'
        ];

        $data2 = [
            'two' => [
                'key' => 'value'
            ],
            'three' => [
                'key' => 'value'
            ],
            'four' => 'value'
        ];

        $this->assertEquals(['four', 'one', 'three', 'two'], getNodeNames($data1, $data2));
    }

    public function testParseFile(): void
    {
        $file1Data = parseFile($this->getFixturePath('file1.json'));
        $file2Data = parseFile($this->getFixturePath('file2.json'));
        $this->assertEquals(DATA_EXPECTED_DATA, getDiff($file1Data, $file2Data));

        $file1Data = parseFile($this->getFixturePath('file1.yml'));
        $file2Data = parseFile($this->getFixturePath('file2.yml'));
        $this->assertEquals(DATA_EXPECTED_DATA, getDiff($file1Data, $file2Data));

        $file1Data = parseFile($this->getFixturePath('file1.json'));
        $file2Data = parseFile($this->getFixturePath('file2.yml'));
        $this->assertEquals(DATA_EXPECTED_DATA, getDiff($file1Data, $file2Data));
    }
}
