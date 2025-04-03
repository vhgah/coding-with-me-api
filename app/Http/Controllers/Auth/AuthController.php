<?php

namespace App\Http\Controllers\Auth;

use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AdminLoginRequest;

class AuthController extends Controller
{
    public function login(AdminLoginRequest $request)
    {
        $validatedData = $request->validated();

        $admin = Admin::query()->where('email', $validatedData['email'])->first();

        if (!$admin || !Hash::check($validatedData['password'], $admin->password)) {
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401);
        }

        $token = $admin->createToken('adminAuthToken')->plainTextToken;

        return response()->json([
            'admin' => $admin->only([
                'id',
                'email',
                'username',
                'last_login_at',
            ]),
            'token' => $token,
        ]);
    }
}
