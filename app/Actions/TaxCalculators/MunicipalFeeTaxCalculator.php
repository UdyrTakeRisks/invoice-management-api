<?php

namespace App\Actions\TaxCalculators;

use App\Interfaces\TaxCalculatorInterface;

class MunicipalFeeTaxCalculator implements TaxCalculatorInterface
{
    public function calculate(float $amount)
    {
        // calculate 2.5 % of amount
        return $amount * 2.5 / 100;
    }
}