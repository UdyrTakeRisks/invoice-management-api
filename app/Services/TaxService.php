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
        // $totalTax = 0;
        // foreach ($this->taxCalculators as $taxCalculator) {
        //     $totalTax += $taxCalculator->calculate($amount);
        // }
        // // array reduce
        $totalTax = array_reduce($this->taxCalculators, fn($carry, $taxCalculator) => $carry += $taxCalculator->calculate($amount), 0.0);
        
        $totalAmount = $amount + $totalTax;
        
        return [
            'tax_amount' => $totalTax,
            'total' => $totalAmount
        ];
    }
}