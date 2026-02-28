<?php

namespace App\Policies;

use App\Enums\InvoiceStatusEnum;
use App\Interfaces\ContractRepositoryInterface;
use App\Interfaces\InvoiceRepositoryInterface;
use App\Models\Contract;
use App\Models\Invoice;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class InvoicePolicy
{
    public function __construct(
        private ContractRepositoryInterface $contractRepo,
        private InvoiceRepositoryInterface $invoiceRepo,
    ) {
    }

    /**
     * Determine whether the user can view the models.
     */
    public function viewAny(User $user, Contract $contract): bool
    {
        // passes if the user and the contract belongs to their tenant
        return $user->tenant_id === $contract->tenant_id;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Invoice $invoice): bool
    {
        // passes if the user and the invoice belongs to their tenant
        // $invoice->contract->tenant_id or use the accessor;
        return $user->tenant_id === $invoice->tenant_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, Contract $contract): bool
    {
        // passes if the user and the contract belongs to their tenant
        return $user->tenant_id === $contract->tenant_id;
    }

    /**
     * Determine whether the user can record payments on invoices belonging to their tenant.
     */
    public function recordPayment(User $user, Invoice $invoice): bool
    {
        // Cancelled invoices can't receive payments
        if ($invoice->status->value == InvoiceStatusEnum::CANCELLED->value) {
            return false;
        }

        // passes if the user and the invoice belongs to their tenant
        // $invoice->contract->tenant_id or use the accessor;
        return $user->tenant_id === $invoice->tenant_id;
    }
}
