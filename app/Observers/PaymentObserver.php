<?php

namespace App\Observers;

use App\Models\Payment;
use App\Traits\ActivityLogTrait;

class PaymentObserver
{
    use ActivityLogTrait;

    /**
     * Handle the Payment "created" event.
     */
    public function created(Payment $payment): void
    {
        $activityName = 'Payment Recorded';
        $event = 'record';
        $message = 'Payment is recorded to the invoice successfully';
        $this->logActivity($activityName, $payment, $event, $message);
    }

}
