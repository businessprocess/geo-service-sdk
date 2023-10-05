<?php

namespace GeoService\Service;

use GeoService\Contracts\HttpClient;
use GeoService\Exceptions\RequestException;
use GeoService\Http\GuzzleClient;
use GeoService\Models\Country;
use GeoService\Models\Model;
use GeoService\Support\Collection;

class GeoService
{
    private HttpClient $client;

    public function __construct(HttpClient $client = null)
    {
        $this->client = $client ?? new GuzzleClient();
    }

    public function setLocale(string $locale): static
    {
        if (method_exists($this->client, 'setLocale')) {
            $this->client->setLocale($locale);
        }

        return $this;
    }

    /**
     * @throws RequestException
     */
    public function getCountryWithChildren(string $id): Country
    {
        return tap($this->country($id), function (Country $country) {
            $country->setChildren(
                $this->getChildById($country->getId())
            );
        });
    }

    /**
     * @return Collection
     *
     * @throws RequestException
     */
    public function countries()
    {
        return $this->client->get('countries')
            ->throw()
            ->collect('items')
            ->mapInto(Country::class);
    }

    /**
     * @throws RequestException
     */
    public function country(string $id): Country
    {
        $response = $this->client->get("countries/$id")
            ->throw()
            ->json();

        return new Country($response);
    }

    /**
     * @return Collection
     *
     * @throws RequestException
     */
    public function getCitiesByCountry(string $id, string $places = 'city,town', string $displayInName = 'city,town', bool $tags = false, bool $details = false)
    {
        return $this->client->get("countries/$id/cities", [
            'details' => $details,
            'tags' => $tags,
            'places' => $places,
            'display-places' => $displayInName,
        ])
            ->throw()
            ->collect('items')
            ->map(fn ($items) => Model::parse($items));
    }

    /**
     * @throws RequestException
     */
    public function getCityById(string $id): ?Model
    {
        $model = $this->getById($id, 'city,town');

        return $model->isCityOrTown() ? $model : null;
    }

    /**
     * @throws RequestException
     */
    public function getById(string $id, string $displayInName = null, bool $tags = true, bool $details = false): Model
    {
        $response = $this->client->get("nodes/$id", [
            'details' => $details,
            'tags' => $tags,
            'display-places' => $displayInName,
        ])
            ->throw()
            ->json('item');

        return Model::parse($response);
    }

    /**
     * @return Collection
     *
     * @throws RequestException
     */
    public function getChildById(string $id)
    {
        return $this->client->get("nodes/$id/children")
            ->throw()
            ->collect('items');
    }

    /**
     * @return Collection
     */
    public function search(
        string $keyword,
        bool $strict = null,
        string $places = null,
        string $displayInName = null,
        string $parentId = null,
        bool $details = false,
        bool $tags = false
    ) {
        if (! is_null($strict)) {
            $strict = $strict ? 'city-strict' : 'city-like';
        }

        return $this->client->get('node-search', [
            'query' => $keyword,
            'query-type' => $strict,
            'details' => $details,
            'tags' => $tags,
            'places' => $places,
            'display-places' => $displayInName,
            'parent-id' => $parentId,
        ])
            ->collect('items')
            ->map(fn ($items) => Model::parse($items));
    }

    public function ping(): bool
    {
        return $this->client->get('ping')->successful();
    }

    public function alive(): bool
    {
        return $this->client->get('utils/alive')->successful();
    }

    public function isServiceId(string $id): bool
    {
        return (bool) preg_match("/^[r|w|n]\d*$/", $id);
    }
}
