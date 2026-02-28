<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait FilterTrait
{
    private function applyFilters(Builder $queryBuilder, $filters)
    {
        if(isset($filters['status'])) {
            $queryBuilder->where('status', '=', $filters['status']);
        }

        if(isset($filters['from_date']) && isset($filters['to_date'])){
            $queryBuilder->whereBetween('created_at', [$filters['from_date'], $filters['to_date']]);
        }
    }
}