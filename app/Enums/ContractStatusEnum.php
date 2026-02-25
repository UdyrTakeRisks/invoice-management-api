<?php

namespace App\Enums;

enum ContractStatusEnum: string
{
    case DRAFT = 'draft';
    case ACTIVE = 'active';
    case EXPIRED = 'expired';
    case TERMINATED = 'terminated';
    
    public static function values(): array
    {
        return array_column(self::cases(), 'value'); // returns ['draft', 'active', 'expired', 'terminated']
    }
}
