<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Resources\LoginAuthResource;

class AuthLoginController extends Controller
{
    public function login(LoginRequest $request)
    {
        if (!auth()->attempt($request->all())) {
            return response(['error' => 'Invalid Credentials'], 401);
        }

        $user = auth()->user();

        return response()->json(LoginAuthResource::make($user));
    }
}
