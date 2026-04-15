<?php

namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;

class ContractNotActiveException extends HttpException
{
    public function __construct()
    {
        parent::__construct(
            422,
            'The Contract is not Active, Please activate it in order to create an Invoice.'
        );
    }
}
