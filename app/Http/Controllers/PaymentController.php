<?php

namespace App\Http\Controllers;

use App\DTOs\RecordPaymentDTO;
use App\Enums\PolicyTypeEnum;
use App\Http\Requests\RecordPaymentRequest;
use App\Http\Resources\PaymentResource;
use App\Models\Invoice;
use App\Services\InvoiceService;
use App\Traits\HttpResponseTrait;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    use HttpResponseTrait;
    public function __construct(
        private InvoiceService $invoiceService
    ) {
    }

    public function record(RecordPaymentRequest $record, Invoice $invoice)
    {
        $this->authorize(PolicyTypeEnum::RECORD_PAYMENT->value, [Invoice::class, $invoice]);

        $dto = RecordPaymentDTO::fromRequest($record, $invoice);

        $payment = $this->invoiceService->recordPayment($dto);

        return $this->created(
            'Payment is recorded successfully',
            PaymentResource::make($payment)
        );
    }
}
