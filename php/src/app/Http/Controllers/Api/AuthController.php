<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Requests\LoginRequest;
use App\Responses\Api\UserLoginResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(LoginRequest $request): UserLoginResponse
    {
        $credentials = $request->validated();

        if (!Auth::attempt($credentials)) {
            throw ValidationException::withMessages(['email' => __('auth.failed')]);
        }

        $request->session()->regenerate();

        return $this->me();
    }

    public function me(): UserLoginResponse
    {
        return new UserLoginResponse(Auth::user());
    }

    public function logout()
    {
        request()->session()->invalidate();

        Auth::logout();

        return response()->json();
    }
}
