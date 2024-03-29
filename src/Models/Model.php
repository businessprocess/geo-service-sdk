<?php

namespace GeoService\Models;

use GeoService\Models\Attributes\Detail;
use GeoService\Models\Attributes\Tag;
use GeoService\Support\Collection;

/**
 * @property-read string $id
 * @property-read string $name
 * @property-read string $code
 * @property-read ?string $place
 * @property-read string $label
 */
abstract class Model implements \ArrayAccess, \JsonSerializable
{
    protected static string $locale = 'ru';

    protected string $id;

    protected string $name;

    protected bool $hasChild;

    protected ?string $place = null;

    protected ?string $osm = null;

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
            $this->__set($key, $value);
        }
    }

    public function toArray(): array
    {
        return [
            'geo_id' => $this->getId(),
            'title' => $this->getName(),
            'code' => $this->getCode(),
            'place' => $this->getPlace(),
            'tags' => $this->getTags()->toArray(),
            'children' => $this->getChildren()->map(fn (Model $model) => $model->toArray())->all(),
            'details' => $this->getDetails()->map(fn (Detail $detail) => $detail->toArray())->all(),
        ];
    }

    public function __toArray(): array
    {
        return $this->toArray();
    }

    public function toString(): string
    {
        return $this->getName();
    }

    public function __toString(): string
    {
        return $this->toString();
    }

    public function __get(string $name): mixed
    {
        $getter = 'get'.ucfirst($name);
        if (method_exists($this, $getter)) {
            return $this->$getter();
        }

        return null;
    }

    public function __set(string $name, mixed $value)
    {
        $method = 'set'.ucfirst($name);
        if (method_exists($this, $method)) {
            try {
                $this->{$method}($value);
            } catch (\Throwable $e) {
            }
        }
    }

    public function __isset(string $name): bool
    {
        return $this->$name !== null;
    }

    public function offsetExists(mixed $offset): bool
    {
        return $this->__isset($offset);
    }

    public function offsetGet(mixed $offset)
    {
        return $this->$offset;
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->$offset = $value;
    }

    public function offsetUnset(mixed $offset): void
    {
        $this->$offset = null;
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }

    public static function setLocale($locale): void
    {
        static::$locale = $locale;
    }

    public static function getLocale(): string
    {
        return static::$locale;
    }

    public static function parse(mixed $response): static
    {
        $class = 'GeoService\\Models\\'.ucfirst($response['place']);

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

    public function getLabel(): string
    {
        return $this->getName();
    }

    public function getCode(): ?string
    {
        return $this->getTags()?->getAlpha2();
    }

    public function getLowerCode(): ?string
    {
        return mb_strtolower($this->getCode(), 'UTF-8');
    }

    public function getChildren()
    {
        return $this->children;
    }

    public function addChild(Model $child): static
    {
        $this->children->push($child);

        return $this;
    }

    /**
     * @param  Collection  $children
     * @return Model
     */
    public function setChildren($children): static
    {
        $this->children = $children;

        return $this;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function isHasChild(): bool
    {
        return $this->hasChild;
    }

    public function setHasChild(bool $hasChild): void
    {
        $this->hasChild = $hasChild;
    }

    public function getTags(): Tag
    {
        return $this->tags;
    }

    /**
     * @param  mixed  $tags
     */
    public function setTags($tags): void
    {
        $this->tags->fill($tags);
    }

    public function getOsm(): ?string
    {
        return $this->osm;
    }

    public function setOsm(string $osm): void
    {
        $this->osm = $osm;
    }

    public function getPlace(): ?string
    {
        return $this->place;
    }

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

    public function setDetails(array|object $details): void
    {
        $this->details = collect((array) $details)->mapInto(Detail::class);
    }

    public function isCityOrTown(): bool
    {
        return $this instanceof City || $this instanceof Town;
    }
}
