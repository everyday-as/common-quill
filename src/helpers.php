<?php

namespace Everyday\CommonQuill;

function array_flatten($array)
{
    if (!is_array($array)) {
        return [$array];
    }

    $result = [];
    foreach ($array as $value) {
        $result = array_merge($result, array_flatten($value));
    }

    return $result;
}
