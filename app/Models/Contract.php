<?php

namespace App\Models;

use App\Enums\ContractStatusEnum;
use App\Enums\InvoiceStatusEnum;
use App\Models\Scopes\TenantScope;
use Date;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ScopedBy(TenantScope::class)]
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

    /**
     * relationships
     */
    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
    public function latest_invoice()
    {
        return $this->hasOne(Invoice::class)->latestOfMany();
    }

    /**
     * Accessors 
     */
    public function getTotalInvoicedAttribute()
    {
        return $this->invoices()->sum('total');
    }
    public function getTotalPaidAttribute()
    {
        return $this->invoices()
            ->where('status', '=', InvoiceStatusEnum::PAID->value)
            ->sum('total');
    }
    public function getOutstandingBalanceAttribute()
    {
        return $this->total_invoiced - $this->total_paid;
    }
    public function getInvoicesCountAttribute()
    {
        return $this->invoices()->count();
    }
    public function getLatestInvoiceDateAttribute()
    {
        return $this->latest_invoice->created_at->format('Y-m-d');
    }
}