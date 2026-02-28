<?php

namespace App\Enums;

enum PolicyTypeEnum: string
{
    case VIEW_ANY = 'viewAny';
    case VIEW = 'view';
    case CREATE = 'create';
    case RECORD_PAYMENT = 'recordPayment';
    
    public static function values(): array
    {
        return array_column(self::cases(), 'value'); // returns ['viewAny', 'view', 'create', 'recordPayment']
    }
}