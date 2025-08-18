<?php

namespace App\Domain\Econt\DTO;

use Illuminate\Support\Arr;

final class Office
{
    public function __construct(
        public readonly string $code,
        public readonly string $name,
        public readonly string $cityName,
        public readonly int $cityPostCode,
        public readonly ?string $addressLine = null,
        public readonly ?float $lat = null,
        public readonly ?float $lng = null,
        /** @var string[]|null */
        public readonly ?array $phones = null,
        public readonly ?string $workTime = null,
    ) {}

    public static function fromArray(array $data): self
    {

        $code = Arr::get($data, 'code') ?? Arr::get($data, 'officeCode') ?? '';

        $city = Arr::get($data, 'city', []) ?: Arr::get($data, 'address.city', []);

        $street = Arr::get($data, 'address.street') ?? Arr::get($data, 'street');
        $num    = Arr::get($data, 'address.num') ?? Arr::get($data, 'num');
        $addr   = trim(implode(' ', array_filter([$street, $num])));

        $lat = Arr::get($data, 'location.lat') ?? Arr::get($data, 'geo.lat');
        $lng = Arr::get($data, 'location.lng') ?? Arr::get($data, 'geo.lng');

        $phones = Arr::get($data, 'phones');
        if (is_string($phones)) {
            $phones = array_map('trim', preg_split('/[,;]+/', $phones));
        }

        return new self(
            code: (string) $code,
            name: (string) Arr::get($data, 'name', ''),
            cityName: (string) Arr::get($city, 'name', ''),
            cityPostCode: (int) (Arr::get($city, 'postCode', 0)),
            addressLine: $addr ?: null,
            lat: $lat !== null ? (float) $lat : null,
            lng: $lng !== null ? (float) $lng : null,
            phones: $phones ?: null,
            workTime: Arr::get($data, 'workTime') ?? Arr::get($data, 'work_time')
        );
    }

    public function toArray(): array
    {
        return [
            'code'        => $this->code,
            'name'        => $this->name,
            'city'        => $this->cityName,
            'postCode'    => $this->cityPostCode,
            'address'     => $this->addressLine,
            'lat'         => $this->lat,
            'lng'         => $this->lng,
            'phones'      => $this->phones,
            'workTime'    => $this->workTime,
        ];
    }
}
