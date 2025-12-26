<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * GET /api/profile
     * Mendapatkan data profil lengkap user yang sedang login
     */
    public function show()
    {
        $user = auth()->user();
        
        // Load relasi berdasarkan role
        if ($user->role === 'public' && $user->region_id) {
            $user->load('region.station');
        } elseif ($user->role === 'petugas') {
            $user->load('assignedStations');
        }

        return response()->json([
            'status' => 'success',
            'data' => $user
        ]);
    }

    /**
     * PUT /api/profile
     * Update profil user
     */
    public function update(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'username' => [
                'sometimes',
                'required',
                'string',
                'max:255',
                Rule::unique('users', 'username')->ignore($user->id)
            ],
            'region_id' => 'sometimes|nullable|exists:regions,id',
        ]);

        $user->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Profil berhasil diperbarui',
            'data' => $user->fresh()
        ]);
    }

    /**
     * PUT /api/profile/password
     * Ganti password
     */
    public function changePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:6|confirmed',
        ]);

        $user = auth()->user();

        // Verifikasi password lama
        if (!Hash::check($validated['current_password'], $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Password lama tidak sesuai'
            ], 422);
        }

        // Update password baru
        $user->update([
            'password' => Hash::make($validated['new_password'])
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Password berhasil diubah'
        ]);
    }

    /**
     * POST /api/profile/photo
     * Upload foto profil
     */
    public function uploadPhoto(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $user = auth()->user();

        // Hapus foto lama jika ada
        if ($user->photo && \Storage::disk('public')->exists($user->photo)) {
            \Storage::disk('public')->delete($user->photo);
        }

        // Upload foto baru
        $path = $request->file('photo')->store('profile_photos', 'public');

        $user->update(['photo' => $path]);

        return response()->json([
            'status' => 'success',
            'message' => 'Foto profil berhasil diupload',
            'data' => [
                'photo_url' => asset('storage/' . $path)
            ]
        ]);
    }
}
