<?php

namespace App\Http\Controllers;

use App\DTOs\CreateInvoiceDTO;
use App\DTOs\RecordPaymentDTO;
use App\Enums\PolicyTypeEnum;
use App\Http\Requests\RecordPaymentRequest;
use App\Http\Requests\StoreInvoiceRequest;
use App\Http\Resources\ContractSummaryResource;
use App\Http\Resources\InvoiceResource;
use App\Http\Resources\PaymentResource;
use App\Models\Contract;
use App\Models\Invoice;
use App\Services\InvoiceService;
use App\Traits\HttpResponseTrait;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    use HttpResponseTrait;
    public function __construct(
        private InvoiceService $invoiceService
    ) {
    }

    public function index(Contract $contract)
    {
        $this->authorize(PolicyTypeEnum::VIEW_ANY->value, [Invoice::class, $contract]);

        $invoices = $this->invoiceService->listInvoice($contract->id);

        return $this->success(
            'Contract Invoices',
            InvoiceResource::collection($invoices)->additional([
                'total' => $invoices->total(),
                'current_page' => $invoices->currentPage(),
                'per_page' => $invoices->perPage(),
                'last_page' => $invoices->lastPage()
            ])
        );
    }

    public function show(Invoice $invoice)
    {
        $this->authorize(PolicyTypeEnum::VIEW->value, [Invoice::class, $invoice]);

        $invoice = $this->invoiceService->getDetailedInvoice($invoice->id);

        return $this->success(
            'Invoice Details with Payments',
            InvoiceResource::make($invoice)
        );
    }

    public function store(StoreInvoiceRequest $request, Contract $contract) 
    {
        $this->authorize(PolicyTypeEnum::CREATE->value, [Invoice::class, $contract]);

        $dto = CreateInvoiceDTO::fromRequest($request, $contract);
        
        $invoice = $this->invoiceService->createInvoice($dto);

        return $this->created(
            'Invoice is created successfully',
            InvoiceResource::make($invoice)
        );
    }
}
