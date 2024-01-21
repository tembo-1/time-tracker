<?php

namespace App\Http\Controllers\Site\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Site\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * @param  LoginRequest  $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request):JsonResponse
    {
        $credentials = $request->validated();

        if (Auth::attempt($credentials)) {
            return response()
                ->json(['message' => 'You are logged in'], 200);
        }

        return response()
            ->json(['message' => 'Invalid username or password'], 403);
    }

    /**
     * @return RedirectResponse
     */
    public function logout():RedirectResponse
    {
        Auth::logout();
        return redirect()
            ->route('mainPage');
    }
}
