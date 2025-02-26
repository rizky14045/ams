<?php

if (!function_exists('html_attributes')) {
    function html_attributes(array $attrs) {
        $results = [];
        foreach($attrs as $attr => $value) {
            $results[] = "{$attr}=\"{$value}\"";
        }
        return implode(" ", $results);
    }
}

if (!function_exists('prev_input')) {
    function prev_input($key) {
        return session($key) ?: old($key);
    }
}

function count_items($items) {
    if (!is_array($items) && false === $items instanceof Countable) {
        return 0;
    }

    return count($items);
}

