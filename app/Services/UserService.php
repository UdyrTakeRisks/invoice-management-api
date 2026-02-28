<?php

namespace App\Services;

use App\Interfaces\UserRepositoryInterface;
use App\DTOs\UserLoginDTO;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class UserService
{
    public function __construct(
        private UserRepositoryInterface $userRepo
    ) {
    }

    public function userLogin(UserLoginDTO $dto)
    {
        // find the user email from the repo
        $user = $this->userRepo->findByEmail($dto->email);
        
        // check if user is not found or Password is not correct
        if (!Hash::check($dto->password, $user->password)) {
            throw ValidationException::withMessages([
                'message' => 'The Login Credentials are Incorrect'
            ]); 
        }

        // If the user is found generate the access token
        $token = $user->createToken('auth-token')->plainTextToken;

        return [
            'user' => $user,
            'token' => $token
        ];
    }
}