<?php

namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;

class ExceededBalanceException extends HttpException
{
    public function __construct() 
    {
        parent::__construct(
            422,
            'The amount exceeds the remaining balance of the invoice'
        );
    }
}
