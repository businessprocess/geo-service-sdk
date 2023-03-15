<?php

namespace GeoService\Models\Traits;

trait Support
{
    public function arrayGet($array, $key = null, $default = null)
    {
        if (is_null($key)) {
            return $array;
        }
        return $array[$key] ?? $default;
    }

    public function arraySet(&$array, $key, $value): void
    {
        if (isset($array[$key])) {
            $array[$key] = $value;
        } else {
            $array = array_merge($array, [$key => $value]);
        }
    }

    public function stringToCamel($value)
    {
        $words = explode(' ', str_replace(['-', '_'], ' ', $value));

        $studlyWords = array_map(fn($word) => ucfirst($word), $words);

        return lcfirst(implode($studlyWords));
    }
}