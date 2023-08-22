<?php

namespace GeoService\Models\Attributes;

use GeoService\Models\Model;

class Tag
{
    protected ?string $alpha2 = null;
    protected ?string $alpha3 = null;
    protected ?string $numeric = null;
    protected array $officialName = [];
    protected array $altName = [];
    protected ?string $isInContinent = null;
    protected ?string $type = null;
    protected ?string $adminLevel = null;
    protected ?string $boundary = null;
    protected ?string $borderType = null;
    protected ?string $defaultLanguage = null;
    protected ?string $wikidata = null;
    protected ?string $wikipedia = null;
    protected ?string $flag = null;
    protected ?string $koatuu = null;
    protected ?string $katotth = null;
    protected ?string $population = null;
    protected ?string $postalCode = null;
    protected ?string $timezone = null;
    protected array $ref = [];
    protected array $attributes = [];

    public function __construct($tags = [])
    {
        $this->fill($tags);
    }

    public function fill($tags)
    {
        foreach ($tags as $key => $value) {
            try {
                if (str_contains($key, ':')) {
                    [$method, $key] = explode(':', $key);

                    if (method_exists($this, $method = str_camel_case($method))) {
                        $this->{$method}($key, $value);
                    }
                } elseif (property_exists($this, $key = str_camel_case($key))) {
                    $this->{$key} = $value;
                } else {
                    $this->setAttribute($key, $value);
                }
            } catch (\Throwable $e) {
            }
        }
    }

    public function toArray(): array
    {
        return [
            'alpha2' => $this->getAlpha2(),
            'alpha3' => $this->getAlpha3(),
            'numeric' => $this->getNumeric(),
            'officialName' => $this->getOfficialName(),
            'altName' => $this->getAltName(),
            'isInContinent' => $this->getIsInContinent(),
            'type' => $this->getType(),
            'adminLevel' => $this->getAdminLevel(),
            'boundary' => $this->getBoundary(),
            'borderType' => $this->getBorderType(),
            'defaultLanguage' => $this->getDefaultLanguage(),
            'wikidata' => $this->getWikidata(),
            'wikipedia' => $this->getWikipedia(),
            'flag' => $this->getFlag(),
            'koatuu' => $this->getKoatuu(),
            'katotth' => $this->getKatotth(),
            'population' => $this->getPopulation(),
            'postalCode' => $this->getPostalCode(),
            'timezone' => $this->getTimezone(),
            'ref' => $this->getRef(),
            'attributes' => $this->getAttribute(),
        ];
    }

    public function getNameByLocale($locale = null, $default = 'en'): ?string
    {
        return $this->getAltName($locale ?? Model::getLocale(), $this->getAltName($default));
    }

    public function getAlpha2(): ?string
    {
        return $this->alpha2;
    }

    public function getAlpha3(): ?string
    {
        return $this->alpha3;
    }

    public function getNumeric(): ?string
    {
        return $this->numeric;
    }

    public function getOfficialName(?string $key = null, ?string $default = null): mixed
    {
        return data_get($this->officialName, $key, $default);
    }

    public function getRef(?string $key = null, ?string $default = null): array
    {
        return data_get($this->ref, $key, $default);
    }

    public function getIsInContinent(): ?string
    {
        return $this->isInContinent;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function getBoundary(): ?string
    {
        return $this->boundary;
    }

    public function getBorderType(): ?string
    {
        return $this->borderType;
    }

    public function getAdminLevel(): ?string
    {
        return $this->adminLevel;
    }

    public function getDefaultLanguage(): ?string
    {
        return $this->defaultLanguage;
    }

    public function getWikidata(): ?string
    {
        return $this->wikidata;
    }

    public function getWikipedia(): ?string
    {
        return $this->wikipedia;
    }

    public function getFlag(): ?string
    {
        return $this->flag;
    }

    public function getKoatuu(): ?string
    {
        return $this->koatuu;
    }

    public function getKatotth(): ?string
    {
        return $this->katotth;
    }

    public function getPopulation(): ?string
    {
        return $this->population;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function getTimezone(): ?string
    {
        return $this->timezone;
    }

    public function getAttribute($key = null, $default = null): array
    {
        return data_get($this->attributes, $key, $default);
    }

    public function setAttribute($key, $value = null): void
    {
        data_set($this->attributes, $key, $value);
    }

    protected function ISO31661($key, $value): void
    {
        $this->{$key} = $value;
    }

    protected function officialName($key, $value): void
    {
        data_set($this->officialName, $key, $value);
    }

    protected function ref($key, $value): void
    {
        data_set($this->ref, $key, $value);
    }

    public function getAltName(?string $key = null, ?string $default = null): mixed
    {
        return data_get($this->altName, $key, $default);
    }

    protected function altName($key, $value): void
    {
        data_set($this->altName, $key, $value);
    }
}