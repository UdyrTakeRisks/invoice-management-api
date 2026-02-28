<?php

namespace App\Repositories;

use App\Interfaces\InvoiceRepositoryInterface;
use Cache;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class CachingInvoiceRepository implements InvoiceRepositoryInterface
{
    public function __construct(
        private InvoiceRepositoryInterface $invoiceRepo
    ) {
    }

    public function getByContractId(int $contractId): Builder
    {
        return $this->invoiceRepo->getByContractId($contractId);
    }
    // tried caching here only
    public function findById(int $invoiceId): Model
    {
        // Cache the result if not found go back to the repo (fallback)
        // Note: Cache invalidate in the invoice observer events
        return Cache::remember('contract.invoice', 3600, function () use ($invoiceId) {
            return $this->invoiceRepo->findById($invoiceId);
        });
    }
    public function create(array $attributes)
    {
        return $this->invoiceRepo->create($attributes);
    }
    public function update(array $attributes, Model $invoice)
    {
        return $this->invoiceRepo->update($attributes, $invoice);
    }
    public function getLastInvoiceNumber()
    {
        return $this->invoiceRepo->getLastInvoiceNumber();
    }
}