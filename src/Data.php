<?php

namespace Differ\Data;

use function Functional\sort;

function getNodeNames(array ...$dataSources): array
{
    return array_reduce($dataSources, function ($carry, $data) {
        $carry = array_unique(array_merge($carry, array_keys($data)));
        return sort($carry, fn ($left, $right) => $left <=> $right);
    }, []);
}

function getDiff(array $data1, array $data2): array
{
    $nodeNames = getNodeNames($data1, $data2);

    return array_map(function ($nodeName) use ($data1, $data2) {
        if (!array_key_exists($nodeName, $data1)) {
            $node = [
                'name' => $nodeName,
                'value' => $data2[$nodeName],
                'status' => 'added'
            ];
        } elseif (!array_key_exists($nodeName, $data2)) {
            $node = [
                'name' => $nodeName,
                'value' => $data1[$nodeName],
                'status' => 'deleted'
            ];
        } elseif ($data1[$nodeName] === $data2[$nodeName]) {
            $node = [
                'name' => $nodeName,
                'value' => $data2[$nodeName],
                'status' => 'unchanged'
            ];
        } elseif (is_array($data1[$nodeName]) && is_array($data2[$nodeName])) {
            $children = getDiff($data1[$nodeName], $data2[$nodeName]);
            $node = [
                'name' => $nodeName,
                'children' => $children,
                'status' => 'nested'
            ];
        } else {
            $node = [
                'name' => $nodeName,
                'oldValue' => $data1[$nodeName],
                'newValue' => $data2[$nodeName],
                'status' => 'changed'];
        }
        return $node;
    }, $nodeNames);

//    return array_reduce($nodeNames, function ($carry, $nodeName) use ($data1, $data2) {
//        if (!array_key_exists($nodeName, $data1)) {
//            $carry[$nodeName] = [
//                'value' => $data2[$nodeName],
//                'status' => 'added'
//            ];
//        } elseif (!array_key_exists($nodeName, $data2)) {
//            $carry[$nodeName] = [
//                'value' => $data1[$nodeName],
//                'status' => 'deleted'
//            ];
//        } elseif ($data1[$nodeName] === $data2[$nodeName]) {
//            $carry[$nodeName] = [
//                'value' => $data2[$nodeName],
//                'status' => 'unchanged'
//            ];
//        } elseif (is_array($data1[$nodeName]) && is_array($data2[$nodeName])) {
//            $children = getDiff($data1[$nodeName], $data2[$nodeName]);
//            $carry[$nodeName] = [
//                'children' => $children,
//                'status' => 'nested'
//            ];
//        } else {
//            $carry[$nodeName] = [
//                'oldValue' => $data1[$nodeName],
//                'newValue' => $data2[$nodeName],
//                'status' => 'changed'];
//        }
//        return $carry;
//    }, []);
}
