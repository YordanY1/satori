<?php

namespace App\Services\Shipping;

use Gdinko\Econt\Enums\LabelMode;

class ShippingCalculator
{
    public function __construct(
        protected EcontLabelService $labelService
    ) {}

    /**
     * Calculate shipping price from Econt by given input
     */
    public function calculate(array $labelInput): float
    {
        $result = $this->labelService->submit($labelInput, LabelMode::CALCULATE);

        $price =
            $result['services']['totalPrice'] ??
            $result['services']['total'] ??
            $result['priceList']['total'] ??
            0.00;

        return (float) $price;
    }
}
