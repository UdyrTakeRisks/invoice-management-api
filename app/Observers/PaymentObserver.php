<?php

namespace App\Observers;

use App\Models\Payment;
use App\Traits\ActivityLogTrait;
use Illuminate\Support\Facades\Cache;

class PaymentObserver
{
    use ActivityLogTrait;

    /**
     * Handle the Payment "created" event.
     */
    public function created(Payment $payment): void
    {
        Cache::forget("contract.invoice.{$payment->invoice_id}");
        
        $activityName = 'Payment Recorded';
        $event = 'record';
        $message = 'Payment is recorded to the invoice successfully';
        $this->logActivity($activityName, $payment, $event, $message);
    }

}
