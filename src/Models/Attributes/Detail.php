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

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'place' => $this->getPlace(),
            'adminLevel' => $this->getAdminLevel(),
        ];
    }

    public function isState(): bool
    {
        return $this->place === 'state';
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPlace(): ?string
    {
        return $this->place;
    }

    public function getAdminLevel(): int
    {
        return $this->adminLevel;
    }
}