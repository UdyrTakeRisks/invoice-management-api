<?php

namespace App\Repositories;

use App\Interfaces\InvoiceRepositoryInterface;
use App\Models\Invoice;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class InvoiceRepository implements InvoiceRepositoryInterface
{
    public function getByContractId(int $contractId): Builder
    {
        return Invoice::query()->where('contract_id', '=', $contractId);
    }

    public function findById(int $invoiceId): Model
    {
        return Invoice::with('payments')->findOrFail($invoiceId);
    }

    public function create(array $attributes)
    {
        $inv = Invoice::create($attributes);
        return $inv->fresh();
    }

    public function update(array $attributes, Model $invoice)
    {
        $invoice->update($attributes);
        return $invoice->fresh();
    }

    public function getLastInvoiceNumber()
    {
        return Invoice::latest()->get('invoice_number')->first();
    }
}