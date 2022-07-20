<?php

namespace Differ\Data;

//function genData(array $rawData): array
//{
//    return array_map(function ($key, $value) {
//        if (is_array($value) && !array_key_exists(0, $value)) {
//            return makeInternalNode($key, genData($value));
//        } else {
//            // TODO: "json_encode" could break array values
//            return makeLeafNode($key, json_encode($value));
//        }
//    }, array_keys($rawData), array_values($rawData));
//}
//
//function makeInternalNode(string $name, array $children): array
//{
//    return [
//        'name' => $name,
//        'type' => 'internalNode',
//        'children' => $children
//    ];
//}
//
//// TODO: maybe "string|array" type hint should be deleted
//function makeLeafNode(string $name, string|array $value): array
//{
//    return [
//        'name' => $name,
//        'type' => 'leafNode',
//        'value' => $value
//    ];
//}
//
//function getNode(array $data, string $nodeName): array
//{
//    foreach ($data as $node) {
//        if ($node['name'] === $nodeName) {
//            return $node;
//        }
//    }
//    return [];
//}
//
//function getNodeChildren(array $node): array
//{
//    return $node['children'];
//}
//
//function isInternalNode(array $node): bool
//{
//    return $node['type'] === 'internalNode';
//}
//
//function isNodeExist(array $data, string $nodeName): bool
//{
//    return !empty(getNode($data, $nodeName));
//}

// TODO: Remove everything above

function makeNode(string $name, $oldValue, $newValue, string $status, array $children = []): array
{
    return [
        'name' => $name,
        'oldValue' => $oldValue,
        'newValue' => $newValue,
        'status' => $status,
        'children' => $children
    ];
}

function getNodeNames(array ...$dataSources): array
{
    return array_reduce($dataSources, function ($carry, $data) {
        $carry = array_unique(array_merge($carry, array_keys($data)));
        sort($carry); // TODO: Delete after debug
        return $carry;
    }, []);
}

function getDiff(array $data1, array $data2): array
{
    $nodeNames = getNodeNames($data1, $data2);

    return array_reduce($nodeNames, function ($carry, $nodeName) use ($data1, $data2) {
        if (!array_key_exists($nodeName, $data1)) {
            $carry[] = makeNode($nodeName, null, $data2[$nodeName], 'added');
        } elseif (!array_key_exists($nodeName, $data2)) {
            $carry[] = makeNode($nodeName, $data1[$nodeName], null, 'deleted');
        } elseif ($data1[$nodeName] === $data2[$nodeName]) {
            $carry[] = makeNode($nodeName, $data1[$nodeName], null, 'unchanged');
        } elseif (is_array($data1[$nodeName]) && is_array($data2[$nodeName])) {
            $children = getDiff($data1[$nodeName], $data2[$nodeName]);
            $carry[] = makeNode($nodeName, null, null, 'nested', $children);
        } else {
            $carry[] = makeNode($nodeName, $data1[$nodeName], $data2[$nodeName], 'changed');
        }
        return $carry;


//        if (array_key_exists($nodeName, $data1)
//            && array_key_exists($nodeName, $data2)
//            && is_array($data2[$nodeName])
//        ) {
//            $children = getDiff($data1[$nodeName], $data2[$nodeName]);
//            $carry[] = makeNode($nodeName, null, 'nested', $children);
//            return $carry;
//        } elseif (!array_key_exists($nodeName, $data1)) {
//            $carry[] = makeNode($nodeName, $data2[$nodeName], 'added');
//            return $carry;
//        } elseif (!array_key_exists($nodeName, $data2)) {
//            $carry[] = makeNode($nodeName, $data1[$nodeName], 'deleted');
//            return $carry;
//        } elseif (array_key_exists($nodeName, $data1) && array_key_exists($nodeName, $data2)) {
//            if ($data1[$nodeName] === $data2[$nodeName]) {
//                $carry[] = makeNode($nodeName, $data1[$nodeName], 'unchanged');
//            } else {
//                $carry[] = makeNode($nodeName, $data1[$nodeName], 'deleted');
//                $carry[] = makeNode($nodeName, $data1[$nodeName], 'added');
//            }
//            return $carry;
//        }

//        if (!array_key_exists($nodeName, $data1)) {
//            $carry[$nodeName] = ['value' => $data2[$nodeName], 'status' => 'added'];
//            return $carry;
//        }
//        if (!array_key_exists($nodeName, $data2)) {
//            $carry[$nodeName] = ['value' => $data1[$nodeName], 'status' => 'deleted'];
//            return $carry;
//        }
//        if ($data1[$nodeName] === $data2[$nodeName]) {
//            $carry[$nodeName] = ['value' => $data2[$nodeName], 'status' => 'unchanged'];
//            return $carry;
//        }
//        if (is_array($data1[$nodeName]) && is_array($data2[$nodeName])) {
//            $children = getDiff($data1[$nodeName], $data2[$nodeName]);
//            $carry[$nodeName] = ['children' => $children, 'status' => 'nested'];
//            return $carry;
//        }
//
//        $carry[$nodeName] = ['oldValue' => $data1[$nodeName], 'newValue' => $data2[$nodeName], 'status' => 'changed'];
//        return $carry;
    }, []);
}
