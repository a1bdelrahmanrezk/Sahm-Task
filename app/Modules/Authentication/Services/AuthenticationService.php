<?php

namespace App\Modules\Authentication\Services;

use Illuminate\Support\Facades\Auth;
use App\Modules\User\Services\UserService;

readonly class AuthenticationService
{
    public function __construct(private UserService $userService) {}

    public function register(array $data)
    {
        return $this->userService->create($data);
    }

    public function login(array $data)
    {

        if (Auth::attempt($data)) {
            $user = $this->userService->find(Auth::user()?->id);
            $user->token = $user->createToken('auth_token')->plainTextToken;
            return $user;
        }
        return false;
    }

    public function logout()
    {
        Auth::user()->tokens()->delete();
    }
}
