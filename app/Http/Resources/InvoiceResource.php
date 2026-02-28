<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'invoice_number' => $this->invoice_number,
            'subtotal' => $this->subtotal,
            'tax_amount' => $this->tax_amount,
            'total' => $this->total,
            'status' => $this->status,
            'due_date' => $this->due_date,
            'paid_at' => $this->paid_at,
            // computed by total - sum payments amount from accessor
            'remaining_balance' => $this->remaining_balance,
            'contract' => $this->whenLoaded('contract', fn() => ContractResource::make($this->contract)),
            'payments' => $this->whenLoaded('payments', fn() => PaymentResource::collection($this->payments)),
        ];
    }
}
