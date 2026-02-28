<?php

namespace App\Enums;

enum PaymentMethodEnum: string
{
    case CASH = 'cash';
    case BANK_TRANSFER = 'bank_transfer';
    case CREDIT_CARD = 'credit_card';
    
    public static function values(): array
    {
        return array_column(self::cases(), 'value'); // returns ['cash', 'bank_transfer', 'credit_card']
    }
}
