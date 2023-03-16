<?php

namespace GeoService\Support;

use ArgumentCountError;

class Collection
{
    protected $items = [];

    public function __construct($items = [])
    {
        $this->items = $items;
    }

    public static function make($items = [])
    {
        return new static($items);
    }

    public function all()
    {
        return $this->items;
    }

    public function count()
    {
        return count($this->items);
    }

    public function first()
    {
        foreach ($this->items as $item) {
            return $item;
        }
        return null;
    }

    public function push(...$values)
    {
        foreach ($values as $value) {
            $this->items[] = $value;
        }

        return $this;
    }

    public function mapInto($class)
    {
        return $this->map(fn($value, $key) => new $class($value, $key));
    }

    public function map(callable $callback)
    {
        $keys = array_keys($this->items);

        try {
            $items = array_map($callback, $this->items, $keys);
        } catch (ArgumentCountError) {
            $items = array_map($callback, $this->items);
        }

        return new static(array_combine($keys, $items));
    }
}