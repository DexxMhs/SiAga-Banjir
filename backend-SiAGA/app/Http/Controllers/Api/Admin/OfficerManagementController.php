<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\Api\Admin\OfficerRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class OfficerManagementController extends Controller
{
    // GET /api/admin/officers
    public function index()
    {
        // Load relasi agar terlihat petugas jaga di stasiun mana saja
        $officers = User::where('role', 'petugas')
            ->with('assignedStations:id,name')
            ->latest()
            ->get();

        return response()->json(['status' => 'success', 'data' => $officers]);
    }

    // POST /api/admin/officers
    public function store(OfficerRequest $request)
    {
        return DB::transaction(function () use ($request) {
            // 1. Buat User Petugas
            $officer = User::create([
                'name'     => $request->name,
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'role'     => 'petugas',
            ]);

            // 2. Tempelkan stasiun tugas jika ada
            if ($request->has('station_ids')) {
                $officer->assignedStations()->sync($request->station_ids);
            }

            return response()->json([
                'status'  => 'success',
                'message' => 'Akun petugas berhasil dibuat dan ditugaskan',
                'data'    => $officer->load('assignedStations:id,name')
            ], 201);
        });
    }

    // GET /api/admin/officers/{id}
    public function show($id)
    {
        $officer = User::where('role', 'petugas')
            ->with('assignedStations:id,name')
            ->findOrFail($id);

        return response()->json(['status' => 'success', 'data' => $officer]);
    }

    // PUT /api/admin/officers/{id}
    public function update(OfficerRequest $request, $id)
    {
        $officer = User::where('role', 'petugas')->findOrFail($id);

        return DB::transaction(function () use ($request, $officer) {
            $data = [
                'name'     => $request->name,
                'username' => $request->username,
            ];

            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password);
            }

            // 1. Update Data Petugas
            $officer->update($data);

            // 2. Sinkronisasi Stasiun Tugas (Hapus yang lama, ganti yang baru)
            if ($request->has('station_ids')) {
                $officer->assignedStations()->sync($request->station_ids);
            }

            return response()->json([
                'status'  => 'success',
                'message' => 'Data petugas dan penugasan berhasil diperbarui',
                'data'    => $officer->load('assignedStations:id,name')
            ]);
        });
    }

    // DELETE /api/admin/officers/{id}
    public function destroy($id)
    {
        $officer = User::where('role', 'petugas')->findOrFail($id);

        // Hapus penugasan di tabel pivot terlebih dahulu (Opsional, tapi bersih)
        $officer->assignedStations()->detach();
        $officer->delete();

        return response()->json(['status' => 'success', 'message' => 'Akun petugas berhasil dihapus']);
    }
}
