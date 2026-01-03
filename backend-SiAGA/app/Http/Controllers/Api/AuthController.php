<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Api\RegisterRequest;
use App\Http\Requests\Api\LoginRequest;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    // Fungsi Register (Public)
    public function register(RegisterRequest $request)
    {
        $validated = $request->validated();

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'username' => $validated['username'],
            'phone' => $validated['phone'],
            'password' => Hash::make($validated['password']),
            'role' => 'public', // Default pendaftaran via app adalah public
            'region_id' => $validated['region_id'],
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Registrasi berhasil',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'username' => $user->username,
                'email' => $user->email ?? '',
                'phone' => $user->phone ?? '',
                'role' => $user->role,
                'region_id' => $user->region_id,
                'photo' => $user->photo ?? '',
                'notification_token' => $user->notification_token ?? ''
            ]
        ], 201);
    }

    // Fungsi Login (Semua Role)
    public function login(LoginRequest $request)
    {
        $validated = $request->validated();

        $user = User::where('email', $validated['email'])->first();

        if (!$user || !Hash::check($validated['password'], $user->password)) {
            return response()->json([
                'message' => 'Email atau password salah'
            ], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login berhasil',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'username' => $user->username,
                'email' => $user->email ?? '',
                'phone' => $user->phone ?? '',
                'role' => $user->role, // Penting untuk navigasi di Flutter
                'region_id' => $user->region_id,
                'photo' => $user->photo ?? '',
                'notification_token' => $user->notification_token ?? ''
            ]
        ]);
    }

    // Fungsi Logout
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Berhasil keluar'
        ]);
    }

    public function updateToken(Request $request)
    {
        $request->validate(['notification_token' => 'required']);

        $request->user()->update([
            'notification_token' => $request->notification_token
        ]);

        return response()->json(['message' => 'Token updated successfully']);
    }
}
