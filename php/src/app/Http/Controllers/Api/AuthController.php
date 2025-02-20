<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Requests\LoginRequest;
use App\Responses\Api\UserLoginResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        if (!Auth::attempt($credentials)) {
            throw ValidationException::withMessages(['email' => __('auth.failed')]);
        }

        $request->session()->regenerate();

        return new UserLoginResponse(Auth::user());
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        return response()->json();
    }
}
