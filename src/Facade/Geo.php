<?php

namespace GeoService\Facade;

use GeoService\Models\City;
use GeoService\Models\Country;
use GeoService\Models\Model;
use GeoService\Models\Town;
use GeoService\Service\GeoService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;

/**
 * @method static GeoService setLocale(string $locale)
 * @method static Country getCountryWithCities(string $id)
 * @method static Collection countries()
 * @method static Country country(string $id)
 * @method static Collection getCitiesByCountry(string $id, string $places = 'city,town', string $displayInName = 'city,town', bool $tags = false, bool $details = false)
 * @method static Model getById(string $id,?string $displayInName = null, bool $tags = true, bool $details = false)
 * @method static Model|null getCityById(string $id)
 * @method static Collection getChildById(string $id)
 * @method static Collection search(string $keyword, ?bool $strict = null, ?string $places = null)
 * @method static bool ping()
 * @method static bool alive()
 * @method static bool isServiceId(string $id)
 */
class Geo extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return GeoService::class;
    }
}
