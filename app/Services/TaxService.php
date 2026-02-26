<?php

namespace App\Services;

class TaxService
{
    public function __construct(
        private array $taxCalculators // binded to an array of objects
    ) {

    }

    public function applyTotalTaxToAmount($amount)
    {
        $totalTax = 0;
        foreach ($this->taxCalculators as $taxCalculator) {
            $totalTax += $taxCalculator->calculate($amount);
        }

        return $amount - $totalTax;
    }
}