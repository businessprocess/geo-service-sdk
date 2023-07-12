<?php

namespace GeoService\Models\Attributes;

class Detail
{
    protected string $id;
    protected string $name;
    protected ?string $place;
    protected int $adminLevel;

    public function __construct($data = [])
    {
        foreach ($data as $key => $value) {
            try {
                $this->{$key} = $value;
            } catch (\Throwable $e) {
            }
        }
    }
}