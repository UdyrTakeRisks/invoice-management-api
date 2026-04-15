<?php

namespace App\Http\Controllers;

use App\Enums\PolicyTypeEnum;
use App\Http\Resources\ContractSummaryResource;
use App\Models\Contract;
use App\Models\Invoice;
use App\Services\InvoiceService;
use App\Traits\HttpResponseTrait;
use Illuminate\Http\Request;

class ContractController extends Controller
{
    use HttpResponseTrait;
    public function __construct(
        private InvoiceService $invoiceService
    ) {
    }

    public function summary(Contract $contract)
    {
        $this->authorize(PolicyTypeEnum::VIEW_ANY->value, [Invoice::class, $contract]);

        $contract = $this->invoiceService->getContractSummary($contract->id);

        return $this->success(
            'Contract Financial Summary Results',
            ContractSummaryResource::make($contract)
        );
    }
}
