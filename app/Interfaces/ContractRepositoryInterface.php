<?php

namespace App\Interfaces;

interface ContractRepositoryInterface
{
    public function findById(int $contractId);
}