<?php

namespace App\Observers;

use App\Enums\InvoiceStatusEnum;
use App\Http\Resources\InvoiceResource;
use App\Models\Invoice;
use Cache;
use Log;

class InvoiceObserver
{
    /**
     * Handle the Invoice "created" event.
     */
    public function created(Invoice $invoice): void
    {
        Cache::forget('contract.invoice');
    }

    /**
     * Handle the Invoice "updated" event.
     */
    public function updated(Invoice $invoice): void
    {
        Cache::forget('contract.invoice');

        if ($invoice->status->value == InvoiceStatusEnum::PAID->value) {
            Log::info('Paid Invoice: ', InvoiceResource::make($invoice)->toArray(request()));
        }
    }
    
    /**
     * Handle the Invoice "deleted" event.
     */
    public function deleted(Invoice $invoice): void
    {
        Cache::forget('contract.invoice');
    }
}
