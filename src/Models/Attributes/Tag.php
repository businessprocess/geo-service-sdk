<?php

namespace GeoService\Models\Attributes;

use GeoService\Models\Model;

class Tag
{
    protected string $alpha2;
    protected string $alpha3;
    protected string $numeric;
    protected array $officialName = [];
    protected array $altName = [];
    protected string $isInContinent;
    protected string $type;
    protected string $adminLevel;
    protected string $boundary;
    protected string $borderType;
    protected string $defaultLanguage;
    protected string $wikidata;
    protected string $wikipedia;
    protected string $flag;
    protected string $koatuu;
    protected string $katotth;
    protected string $population;
    protected string $postalCode;
    protected string $timezone;
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

    public function getNameByLocale($locale = null, $default = 'en'): ?string
    {
        return $this->getAltName($locale ?? Model::getLocale(), $this->getAltName($default));
    }

    /**
     * @return string
     */
    public function getAlpha2(): string
    {
        return $this->alpha2;
    }

    /**
     * @return string
     */
    public function getAlpha3(): string
    {
        return $this->alpha3;
    }

    /**
     * @return string
     */
    public function getNumeric(): string
    {
        return $this->numeric;
    }

    /**
     * @return array|string|null
     */
    public function getOfficialName(?string $key = null, ?string $default = null): mixed
    {
        return data_get($this->officialName, $key, $default);
    }

    /**
     * @param string|null $key
     * @param string|null $default
     * @return array
     */
    public function getRef(?string $key = null, ?string $default = null): array
    {
        return data_get($this->ref, $key, $default);
    }

    /**
     * @return string
     */
    public function getIsInContinent(): string
    {
        return $this->isInContinent;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getBoundary(): string
    {
        return $this->boundary;
    }

    public function getBorderType(): string
    {
        return $this->borderType;
    }

    /**
     * @return string
     */
    public function getAdminLevel(): string
    {
        return $this->adminLevel;
    }

    /**
     * @return string
     */
    public function getDefaultLanguage(): string
    {
        return $this->defaultLanguage;
    }

    public function getWikidata(): string
    {
        return $this->wikidata;
    }

    public function getWikipedia(): string
    {
        return $this->wikipedia;
    }

    public function getFlag(): string
    {
        return $this->flag;
    }

    /**
     * @return string
     */
    public function getKoatuu(): string
    {
        return $this->koatuu;
    }

    /**
     * @return string
     */
    public function getKatotth(): string
    {
        return $this->katotth;
    }

    /**
     * @return string
     */
    public function getPopulation(): string
    {
        return $this->population;
    }

    /**
     * @return string
     */
    public function getPostalCode(): string
    {
        return $this->postalCode;
    }

    /**
     * @return string
     */
    public function getTimezone(): string
    {
        return $this->timezone;
    }

    /**
     * @param null $key
     * @param null $default
     * @return array
     */
    public function getAttribute($key = null, $default = null): array
    {
        return data_get($this->attributes, $key, $default);
    }

    /**
     * @param $key
     * @param null $value
     */
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