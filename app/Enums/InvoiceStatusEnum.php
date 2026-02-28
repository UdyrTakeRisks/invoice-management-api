<?php

namespace App\Enums;

enum InvoiceStatusEnum: string
{
    case PENDING = 'pending';
    case PAID = 'paid';
    case PARTIALLY_PAID = 'partially_paid';
    case OVERDUE = 'overdue';
    case CANCELLED = 'cancelled';
    
    public static function values(): array
    {
        return array_column(self::cases(), 'value'); // returns ['pending', 'paid', 'partially_paid', 'overdue', 'cancelled']
    }
}
