<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContractSummaryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'contract_id' => $this->id,
            'total_invoiced' => $this->total_invoiced, // sum total
            'total_paid' => $this->total_paid, // sum total -> status = paid
            'outstanding_balance' => $this->outstanding_balance, // invoiced - paid 
            'invoices_count' => $this->invoices_count,
            'latest_invoice_date' => $this->latest_invoice_date,
        ];
    }
}
