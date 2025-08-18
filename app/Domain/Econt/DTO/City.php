<?php

namespace App\Domain\Econt\DTO;

use Illuminate\Support\Arr;

final class City
{
    public function __construct(
        public readonly string $name,
        public readonly int $postCode,
        public readonly string $countryCode3 = 'BGR',
        public readonly ?string $region = null,
        public readonly ?int $id = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            name: (string) Arr::get($data, 'name', ''),
            postCode: (int) Arr::get($data, 'postCode', 0),
            countryCode3: (string) Arr::get($data, 'country.code3', 'BGR'),
            region: Arr::get($data, 'region.name') ?? Arr::get($data, 'region'),
            id: Arr::get($data, 'id') ?? Arr::get($data, 'cityId')
        );
    }

    public function toArray(): array
    {
        return [
            'name'         => $this->name,
            'postCode'     => $this->postCode,
            'countryCode3' => $this->countryCode3,
            'region'       => $this->region,
            'id'           => $this->id,
        ];
    }
}
