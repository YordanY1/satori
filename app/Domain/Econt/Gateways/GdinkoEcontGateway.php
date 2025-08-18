<?php

namespace App\Domain\Econt\Gateways;

use App\Domain\Econt\Contracts\EcontGateway;
use Gdinko\Econt\Facades\Econt;

class GdinkoEcontGateway implements EcontGateway
{
    public function fetchCities(): array
    {
        /** @var array<int, array<string,mixed>> $cities */
        $cities = Econt::getCities();
        return $cities;
    }

    public function fetchOffices(): array
    {
        /** @var array<int, array<string,mixed>> $offices */
        $offices = Econt::getOffices();
        return $offices;
    }
}
