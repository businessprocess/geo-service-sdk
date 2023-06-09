<?php

namespace GeoService\Models;

use GeoService\Models\Attributes\Detail;
use GeoService\Models\Attributes\Tag;
use GeoService\Support\Collection;

abstract class Model
{
    protected static string $locale = 'ru';

    protected string $id;
    protected string $name;
    protected bool $hasChild;
    protected ?string $place;
    protected string $osm;
    protected Tag $tags;
    /**
     * @var Collection|mixed
     */
    protected $details;

    /**
     * @var Collection|mixed
     */
    protected $children;

    public function __construct($data = [])
    {
        $this->details = collect();
        $this->children = collect();
        $this->tags = new Tag();

        foreach ($data as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (method_exists($this, $method)) {
                $this->{$method}($value);
            }
        }
    }

    public function toArray(): array
    {
        return [
            'geo_id' => $this->getId(),
            'title' => $this->getTags()->getNameByLocale() ?? $this->getName(),
            'place' => $this->getPlace(),
            'children' => $this->getChildren()->map(fn(Model $model) => $model->toArray())->all()
        ];
    }

    public function __toArray(): array
    {
        return $this->toArray();
    }

    public static function setLocale($locale): void
    {
        static::$locale = $locale;
    }

    /**
     * @return string
     */
    public static function getLocale(): string
    {
        return static::$locale;
    }

    public static function parse(mixed $response): static
    {
        $class = 'GeoService\\Models\\' . ucfirst($response['place']);

        return class_exists($class) ? new $class($response) : new Undefined($response);
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return Collection
     */
    public function getChildren(): Collection
    {
        return $this->children;
    }

    public function addChild(Model $child): static
    {
        $this->children->push($child);

        return $this;
    }

    /**
     * @param Collection $children
     * @return Model
     */
    public function setChildren($children): static
    {
        $this->children = $children;

        return $this;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * @return bool
     */
    public function isHasChild(): bool
    {
        return $this->hasChild;
    }

    /**
     * @param bool $hasChild
     */
    public function setHasChild(bool $hasChild): void
    {
        $this->hasChild = $hasChild;
    }

    /**
     * @return Tag
     */
    public function getTags(): Tag
    {
        return $this->tags;
    }

    /**
     * @param mixed $tags
     */
    public function setTags($tags): void
    {
        $this->tags->fill($tags);
    }

    /**
     * @return string
     */
    public function getOsm(): string
    {
        return $this->osm;
    }

    /**
     * @param string $osm
     */
    public function setOsm(string $osm): void
    {
        $this->osm = $osm;
    }

    /**
     * @return string|null
     */
    public function getPlace(): ?string
    {
        return $this->place;
    }

    /**
     * @param string $place
     */
    public function setPlace(string $place): void
    {
        $this->place = $place;
    }

    /**
     * @return Collection
     */
    public function getDetails()
    {
        return $this->details;
    }

    /**
     * @param array|object $details
     */
    public function setDetails(array|object $details): void
    {
        $this->details = collect((array)$details)->mapInto(Detail::class);
    }
}