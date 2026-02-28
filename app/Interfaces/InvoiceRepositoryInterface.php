<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

interface InvoiceRepositoryInterface
{
    public function getByContractId(int $contractId): Builder;
    public function findById(int $invoiceId): Model;
    public function create(array $attributes);
    public function update(array $attributes, Model $invoice);
    public function getLastInvoiceNumber();
}