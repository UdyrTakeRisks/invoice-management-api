<?php

namespace App\DTOs;

use App\Http\Requests\UserLoginRequest;

class UserLoginDTO
{
    public function __construct(
        public readonly string $email,
        public readonly string $password,
    ) {
    }
    public static function fromRequest(UserLoginRequest $request): self
    {
        return new self(
            email: $request->validated('email'),
            password: $request->validated('password'),
        );
    }
}
