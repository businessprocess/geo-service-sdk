<?php

if (!function_exists('tap')) {
    /**
     * Call the given Closure with the given value then return the value.
     *
     * @param mixed $value
     * @param callable|null $callback
     * @return mixed
     */
    function tap($value, $callback)
    {
        $callback($value);

        return $value;
    }
}

if (!function_exists('collect')) {
    /**
     * Call the given Closure with the given value then return the value.
     *
     * @param mixed $value
     * @param callable|null $callback
     * @return mixed
     */
    function collect($items = [])
    {
        return new \GeoService\Support\Collection($items);
    }
}

if (!function_exists('data_get')) {

    function data_get($array, $key = null, $default = null)
    {
        if (is_null($key)) {
            return $array;
        }
        return $array[$key] ?? $default;
    }
}
if (!function_exists('data_set')) {

    function data_set(&$array, $key, $value)
    {
        if (isset($array[$key])) {
            $array[$key] = $value;
        } else {
            $array = array_merge($array, [$key => $value]);
        }
    }
}
if (!function_exists('str_camel_case')) {

    function str_camel_case($value)
    {
        $words = explode(' ', str_replace(['-', '_'], ' ', $value));

        $studlyWords = array_map(fn($word) => ucfirst($word), $words);

        return lcfirst(implode($studlyWords));
    }
}