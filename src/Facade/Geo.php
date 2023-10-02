<?php

namespace GeoService\Facade;

use GeoService\Models\City;
use GeoService\Models\Country;
use GeoService\Service\GeoService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;

/**
 * @method static Country getCountryWithChildren(string $id)
 * @method static Collection countries()
 * @method static Country country(string $id)
 * @method static Collection getCitiesByCountry(string $id, bool $tags = true, bool $details = false)
 * @method static Country|City getById(string $id, bool $tags = true, bool $details = false)
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
