<?php

namespace App\Repositories;

use App\Interfaces\PaymentRepositoryInterface;
use App\Models\Payment;

class PaymentRepository implements PaymentRepositoryInterface
{
    public function create(array $attributes)
    { 
        return Payment::create($attributes);
    }
}