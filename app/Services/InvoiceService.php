<?php

namespace App\Services;

use App\Actions\InvoiceNumberGenerator;
use App\DTOs\CreateInvoiceDTO;
use App\DTOs\RecordPaymentDTO;
use App\Enums\ContractStatusEnum;
use App\Enums\InvoiceStatusEnum;
use App\Exceptions\ContractNotActiveException;
use App\Exceptions\ExceededBalanceException;
use App\Exceptions\InsufficientBalanceException;
use App\Interfaces\ContractRepositoryInterface;
use App\Interfaces\InvoiceRepositoryInterface;
use App\Interfaces\PaymentRepositoryInterface;
use App\Traits\FilterTrait;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class InvoiceService
{
    use FilterTrait;
    public function __construct(
        private ContractRepositoryInterface $contractRepo,
        private InvoiceRepositoryInterface $invoiceRepo,
        private PaymentRepositoryInterface $paymentRepo,
        private TaxService $taxService,
    ) {
    }

    public function listInvoice(int $contractId): LengthAwarePaginator
    {
        $filters = request()->only('limit', 'status', 'from_date', 'to_date');
        $invoices = $this->invoiceRepo->getByContractId($contractId);

        //apply pagination and filters
        $this->applyFilters($invoices, $filters);
        $limit = $filters['limit'] ?? 10;

        return $invoices->paginate($limit);
    }

    public function getDetailedInvoice(int $invoiceId)
    {
        return $this->invoiceRepo->findById($invoiceId);
    }

    public function createInvoice(CreateInvoiceDTO $dto)
    {
        // multi-step DB operations wrapped in a transaction for atomicity
        return DB::transaction(function () use ($dto) {

            // validate if contract is not active throw ContractNotActiveException
            $contract = $this->contractRepo->findById($dto->contract_id);

            if ($contract->status->value != ContractStatusEnum::ACTIVE->value) {
                throw new ContractNotActiveException();
            }

            // calculate taxes
            $tax = $this->taxService->applyTotalTaxToAmount($dto->subtotal);

            // generate invoice number
            $lastInvoiceNumber = $this->invoiceRepo->getLastInvoiceNumber();
            $invoiceNumber = InvoiceNumberGenerator::generateInvoiceNumber($contract->tenant_id, $lastInvoiceNumber);

            // store the invoice via repo
            $attributes = array_merge($tax, [
                'tenant_id' => $dto->tenant_id,
                'contract_id' => $contract->id,
                'invoice_number' => $invoiceNumber,
                'subtotal' => $dto->subtotal,
                'due_date' => $dto->due_date
            ]);

            return $this->invoiceRepo->create($attributes);
        });
    }

    public function recordPayment(RecordPaymentDTO $dto)
    {
        return DB::transaction(function () use ($dto) {

            $invoice = $this->invoiceRepo->findById($dto->invoice_id);

            // validate amount
            if ($dto->amount > $invoice->remaining_balance) {
                throw new ExceededBalanceException();
            }

            $totalPayments = $dto->amount + $invoice->sum_payments;
           
            // update invoice status
            if ($totalPayments === (float) $invoice->total) {
                $attributes = [
                    'status' => InvoiceStatusEnum::PAID->value,
                    'paid_at' => now()->toDateString()
                ];
            } else {
                $attributes = [
                    'status' => InvoiceStatusEnum::PARTIALLY_PAID->value,
                    'paid_at' => now()->toDateString()
                ];
            }
            
            $this->invoiceRepo->update($attributes, $invoice);

            // store via repo
            $attributes = [
                'invoice_id' => $invoice->id,
                'amount' => $dto->amount,
                'payment_method' => $dto->payment_method,
                'reference_number' => $dto->reference_number,
                'paid_at' => now()->toDateString(),
            ];

            return $this->paymentRepo->create($attributes);

        });
    }

    public function getContractSummary(int $contractId)
    {
        return $this->contractRepo->findById($contractId);
    }

}