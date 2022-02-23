<?php

namespace Everyday\CommonQuill;

function array_flatten(array $array): array
{
    array_walk_recursive($array, static function ($item) use (&$out) {
        $out[] = $item;
    });

    return $out;
}
