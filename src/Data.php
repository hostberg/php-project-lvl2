<?php

namespace Differ\Data;

function getNodeNames(array ...$dataSources): array
{
    return array_reduce($dataSources, function ($carry, $data) {
//        $carry = array_unique(array_merge($carry, array_keys($data)));
//        sort($carry); // TODO: Delete after debug
//        return $carry;
        return array_unique(array_merge($carry, array_keys($data)));
    }, []);
}

//function getDiff(array $data1, array $data2): array
//{
//    $nodeNames = getNodeNames($data1, $data2);
//    sort($nodeNames);
//
//    return array_reduce($nodeNames, function ($carry, $nodeName) use ($data1, $data2) {
//        if (!array_key_exists($nodeName, $data1)) {
////            $carry[$nodeName] = [
////                'value' => $data2[$nodeName],
////                'status' => 'added'
////            ];
//            $carry += [
//                'name' => $nodeName,
//                'value' => $data2[$nodeName],
//                'status' => 'added'
//            ];
//        } elseif (!array_key_exists($nodeName, $data2)) {
////            $carry[$nodeName] = [
////                'value' => $data1[$nodeName],
////                'status' => 'deleted'
////            ];
//            $carry += [
//                'name' => $nodeName,
//                'value' => $data1[$nodeName],
//                'status' => 'deleted'
//            ];
//        } elseif ($data1[$nodeName] === $data2[$nodeName]) {
////            $carry[$nodeName] = [
////                'value' => $data2[$nodeName],
////                'status' => 'unchanged'
////            ];
//            $carry += [
//                'name' => $nodeName,
//                'value' => $data2[$nodeName],
//                'status' => 'unchanged'
//            ];
//        } elseif (is_array($data1[$nodeName]) && is_array($data2[$nodeName])) {
//            $children = getDiff($data1[$nodeName], $data2[$nodeName]);
////            $carry[$nodeName] = [
////                'children' => $children,
////                'status' => 'nested'
////            ];
//            $carry += [
//                'name' => $nodeName,
//                'children' => $children,
//                'status' => 'nested'
//            ];
//        } else {
////            $carry[$nodeName] = [
////                'oldValue' => $data1[$nodeName],
////                'newValue' => $data2[$nodeName],
////                'status' => 'changed'];
//            $carry += [
//                'name' => $nodeName,
//                'oldValue' => $data1[$nodeName],
//                'newValue' => $data2[$nodeName],
//                'status' => 'changed'
//            ];
//        }
//        return $carry;
//    }, []);
//}


function getDiff(array $data1, array $data2): array
{
    $nodeNames = getNodeNames($data1, $data2);
    sort($nodeNames);

    return array_reduce($nodeNames, function ($carry, $nodeName) use ($data1, $data2) {
        if (!array_key_exists($nodeName, $data1)) {
//            $carry[$nodeName] = [
//                'value' => $data2[$nodeName],
//                'status' => 'added'
//            ];
            $carry += [
                $nodeName => [
                    'value' => $data2[$nodeName],
                    'status' => 'added'
                ]
            ];
        } elseif (!array_key_exists($nodeName, $data2)) {
//            $carry[$nodeName] = [
//                'value' => $data1[$nodeName],
//                'status' => 'deleted'
//            ];
            $carry += [
                $nodeName => [
                    'value' => $data1[$nodeName],
                    'status' => 'deleted'
                ]
            ];
        } elseif ($data1[$nodeName] === $data2[$nodeName]) {
//            $carry[$nodeName] = [
//                'value' => $data2[$nodeName],
//                'status' => 'unchanged'
//            ];
            $carry += [
                $nodeName => [
                    'value' => $data2[$nodeName],
                    'status' => 'unchanged'
                ]
            ];
        } elseif (is_array($data1[$nodeName]) && is_array($data2[$nodeName])) {
            $children = getDiff($data1[$nodeName], $data2[$nodeName]);
//            $carry[$nodeName] = [
//                'children' => $children,
//                'status' => 'nested'
//            ];
            $carry += [
                $nodeName => [
                    'children' => $children,
                    'status' => 'nested'
                ]
            ];
        } else {
//            $carry[$nodeName] = [
//                'oldValue' => $data1[$nodeName],
//                'newValue' => $data2[$nodeName],
//                'status' => 'changed'];
            $carry += [
                $nodeName => [
                    'oldValue' => $data1[$nodeName],
                    'newValue' => $data2[$nodeName],
                    'status' => 'changed'
                ]
            ];
        }
        return $carry;
    }, []);
}


//function getDiff(array $data1, array $data2): array
//{
//    $nodeNames = getNodeNames($data1, $data2);
//
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
//}
