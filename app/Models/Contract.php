<?php

namespace App\Models;

use App\Enums\ContractStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;

    protected $fillable = [
        'unit_name',
        'customer_name',
        'rent_amount',
        'start_date',
        'end_date',
        'status'
    ];

    protected $casts = [
        'status' => ContractStatusEnum::class
    ];
}