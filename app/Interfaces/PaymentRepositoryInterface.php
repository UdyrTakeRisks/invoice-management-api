<?php

namespace App\Interfaces;

interface PaymentRepositoryInterface
{
    public function create(array $attributes);
}