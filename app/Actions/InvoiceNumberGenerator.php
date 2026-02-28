<?php

namespace App\Actions;

use Illuminate\Database\Eloquent\Collection;

class InvoiceNumberGenerator
{
    public static function generateInvoiceNumber($tenantId, $lastInvoiceNumber)
    {
        $yearMonth = now()->format('Ym');
        $paddedTenantId = str_pad($tenantId, 3, '0', STR_PAD_LEFT);
        
        if($lastInvoiceNumber) {
            $lastSequence = (int) substr($lastInvoiceNumber->invoice_number, -4);
            $sequence = str_pad($lastSequence + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $sequence = '0001';
        }

        return "INV-{$paddedTenantId}-{$yearMonth}-{$sequence}";
    }
}