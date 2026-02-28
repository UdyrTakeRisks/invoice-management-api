<?php

namespace App\Actions\TaxCalculators;

use App\Interfaces\TaxCalculatorInterface;

class VATTaxCalculator implements TaxCalculatorInterface
{
    public function calculate(float $amount)
    {
        // calculate 15 % of amount
        return $amount * 15 / 100;
    }
}