<?php

namespace App\Interfaces;

interface TaxCalculatorInterface
{
    public function calculate(float $amount);
}