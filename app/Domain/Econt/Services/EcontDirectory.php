<?php

namespace App\Domain\Econt\Services;

use App\Domain\Econt\Contracts\EcontGateway;
use App\Domain\Econt\DTO\City;
use App\Domain\Econt\DTO\Office;
use Illuminate\Contracts\Cache\Repository as Cache;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class EcontDirectory
{
    public function __construct(
        private readonly EcontGateway $gateway,
        private readonly Cache $cache
    ) {}

    /** @return Collection<int, City> */
    public function cities(?string $q = null): Collection
    {
        $raw = $this->cache->remember('econt:cities:all', now()->addHours(8), fn() => $this->gateway->fetchCities());

        $cities = collect($raw)
            ->map(fn(array $c) => City::fromArray($c));

        if ($q !== null && $q !== '') {
            $needle = Str::of($q)->lower();
            $cities = $cities->filter(function (City $c) use ($needle) {
                return Str::of($c->name)->lower()->contains($needle)
                    || Str::of((string) $c->postCode)->startsWith($needle);
            });
        }

        return $cities->values();
    }

    /** @return Collection<int, Office> */
    public function officesByCity(string $cityName): Collection
    {
        $raw = $this->cache->remember('econt:offices:all', now()->addHours(4), fn() => $this->gateway->fetchOffices());

        $cityNorm = Str::lower($cityName);

        return collect($raw)
            ->map(fn(array $o) => Office::fromArray($o))
            ->filter(fn(Office $o) => Str::lower($o->cityName) === $cityNorm)
            ->values();
    }
}
