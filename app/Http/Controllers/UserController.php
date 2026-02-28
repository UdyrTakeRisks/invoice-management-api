<?php

namespace App\Http\Controllers;

use App\DTOs\UserLoginDTO;
use App\Http\Requests\UserLoginRequest;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use App\Traits\HttpResponseTrait;

class UserController extends Controller
{
    use HttpResponseTrait;
    public function __construct(
        private UserService $userService
    ) {
    }
    
    public function login(UserLoginRequest $request)
    {
        $dto = UserLoginDTO::fromRequest($request);
        
        $data = $this->userService->userLogin($dto);

        return $this->success(
            'User Logged in Successfully',
            [
                UserResource::make($data['user']),
                'token' => $data['token']
            ]
        );
    }
}
