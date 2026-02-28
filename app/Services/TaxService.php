<?php

namespace App\Services;

use App\Interfaces\TaxCalculatorInterface;

class TaxService
{
    protected $taxCalculators;
    public function __construct(
        // TaxCalculatorInterface[] $taxCalculators
        TaxCalculatorInterface ...$taxCalculators // binded to an array of resolved instances / objects
    ) {
        $this->taxCalculators = $taxCalculators;
    }

    public function applyTotalTaxToAmount($amount)
    {
        $totalTax = 0;
        foreach ($this->taxCalculators as $taxCalculator) {
            $totalTax += $taxCalculator->calculate($amount);
        }

        $totalAmount = $amount + $totalTax;
        
        return [
            'tax_amount' => $totalTax,
            'total' => $totalAmount
        ];
    }
}