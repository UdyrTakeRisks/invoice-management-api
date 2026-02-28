<?php

namespace App\Repositories;

use App\Interfaces\ContractRepositoryInterface;
use App\Models\Contract;

class ContractRepository implements ContractRepositoryInterface
{
    public function findById($contractId)
    {
        return Contract::findOrFail($contractId);
    }
}