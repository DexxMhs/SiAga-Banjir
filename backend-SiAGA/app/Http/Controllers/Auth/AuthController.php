<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login', [
            "title" => "Login"
        ]);
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }

    public function logout(Request $request)
    {
        // 1. Hapus Token Sanctum (jika Anda memakainya)
        if ($request->user()) {
            $request->user()->tokens()->delete();
        }

        // 2. Logout dari Guard Web (Session)
        Auth::guard('web')->logout();

        // 3. Hancurkan Session user
        $request->session()->invalidate();

        // 4. Buat ulang CSRF token baru agar session lama tidak bisa dipakai lagi
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
