<?php

namespace GeoService\Models\Attributes;

class Detail
{
    protected string $id;
    protected string $name;
    protected string $place;
    protected int $adminLevel;

    public function __construct($data = [])
    {
        foreach ($data as $key => $value) {
            $this->{$key}($value);
        }
    }
}