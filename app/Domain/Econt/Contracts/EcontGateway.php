<?php

namespace App\Domain\Econt\Contracts;

interface EcontGateway
{
    public function fetchCities(): array;
    public function fetchOffices(): array;
}
