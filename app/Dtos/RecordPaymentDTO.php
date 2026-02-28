<?php

namespace App\DTOs;

use App\Http\Requests\RecordPaymentRequest;
use App\Models\Invoice;

class RecordPaymentDTO
{
    public function __construct(
        public readonly int $invoice_id,
        public readonly float $amount,
        public readonly string $payment_method,
        public readonly string $reference_number,
    ) {
    }

    public static function fromRequest(RecordPaymentRequest $request, Invoice $invoice): self
    {
        return new self(
            invoice_id: $invoice->id,
            amount: $request->validated('amount'),
            payment_method: $request->validated('payment_method'),
            reference_number: $request->validated('reference_number'),
        );
    }
}