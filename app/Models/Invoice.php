<?php

namespace App\Models;

use App\Enums\InvoiceStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'contract_id',
        'subtotal',
        'due_date',
        'tax_amount',
        'total',
        'invoice_number',
        'status',
        'paid_at'
    ];

    protected $casts = [
        'status' => InvoiceStatusEnum::class
    ];

    /**
     * relationships
     */
    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Accessors 
     */
    // (Note: call it as tenant_id)
    public function getTenantIdAttribute()
    {
        return $this->contract?->tenant_id;
    }
    // (Note: call it as sum_payments)
    public function getSumPaymentsAttribute()
    {
        return $this->payments()->sum('amount');
    }
    public function getRemainingBalanceAttribute()
    {
        return $this->total - $this->sum_payments;
    }
}
