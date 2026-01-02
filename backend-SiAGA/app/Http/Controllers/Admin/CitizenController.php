<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Region; // Import model Region untuk dropdown
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class CitizenController extends Controller
{
    /**
     * Menampilkan daftar masyarakat (User dengan role 'public').
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $citizens = User::where('role', 'public')
            // Load relasi region untuk menampilkan nama wilayah
            ->with(['region', 'publicReports'])
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('username', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->withCount('publicReports') // Hitung jumlah laporan
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.pages.citizens.index', compact('citizens'));
    }

    /**
     * Form tambah user masyarakat baru.
     */
    public function create()
    {
        // Ambil data region untuk dropdown (optional jika user harus pilih wilayah)
        $regions = Region::all();
        return view('admin.pages.citizens.create', compact('regions'));
    }

    /**
     * Simpan data user baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'username'    => 'required|string|max:255|unique:users,username',
            'email'       => 'required|email|unique:users,email',
            'password'    => 'required|string|min:8|confirmed',
            'nomor_induk' => 'nullable|string|max:50', // NIK
            'region_id'   => 'nullable|exists:regions,id',
        ]);

        User::create([
            'name'        => $request->name,
            'username'    => $request->username,
            'email'       => $request->email,
            'password'    => Hash::make($request->password),
            'role'        => 'public', // Default role
            'nomor_induk' => $request->nomor_induk,
            'region_id'   => $request->region_id,
        ]);

        return redirect()->route('citizens.index')
            ->with('success', 'Akun masyarakat berhasil dibuat.');
    }

    /**
     * Tampilkan detail masyarakat.
     */
    public function show(string $id)
    {
        $citizen = User::where('role', 'public')
            ->with(['region', 'publicReports' => function ($q) {
                $q->latest()->limit(5);
            }])
            ->findOrFail($id);

        return view('admin.pages.citizens.show', compact('citizen'));
    }

    /**
     * Form edit data masyarakat.
     */
    public function edit(string $id)
    {
        $citizen = User::where('role', 'public')->findOrFail($id);
        $regions = Region::all(); // Untuk dropdown edit

        return view('admin.pages.citizens.edit', compact('citizen', 'regions'));
    }

    /**
     * Update data masyarakat.
     */
    public function update(Request $request, string $id)
    {
        $citizen = User::where('role', 'public')->findOrFail($id);

        $request->validate([
            'name'        => 'required|string|max:255',
            // Validasi Unique kecuali ID user ini sendiri
            'username'    => ['required', 'string', Rule::unique('users')->ignore($citizen->id)],
            'email'       => ['required', 'email', Rule::unique('users')->ignore($citizen->id)],
            'password'    => 'nullable|string|min:8|confirmed', // Isi jika ingin ubah password
            'nomor_induk' => 'nullable|string|max:50',
            'region_id'   => 'required|exists:regions,id',
            'photo'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:800',
        ]);

        $data = [
            'name'        => $request->name,
            'username'    => $request->username,
            'email'       => $request->email,
            'nomor_induk' => $request->nomor_induk,
            'region_id'   => $request->region_id,
        ];

        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada (dan bukan default)
            if ($citizen->photo && Storage::exists('public/' . $citizen->photo)) {
                Storage::delete('public/' . $citizen->photo);
            }
            // Simpan foto baru ke folder 'officers' di storage public
            $path = $request->file('photo')->store('officers', 'public');
            $data['photo'] = $path;
        }

        // 3. Handle Hapus Foto (Jika user klik tombol hapus)
        if ($request->boolean('delete_photo_flag')) {
            if ($citizen->photo && Storage::exists('public/' . $citizen->photo)) {
                Storage::delete('public/' . $citizen->photo);
            }
            $data['photo'] = null;
        }

        // Hanya update password jika input tidak kosong
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $citizen->update($data);

        return redirect()->route('citizens.index')
            ->with('success', 'Data masyarakat berhasil diperbarui.');
    }

    /**
     * Hapus akun masyarakat.
     */
    public function destroy(string $id)
    {
        $citizen = User::where('role', 'public')->findOrFail($id);
        $citizen->delete();

        return redirect()->route('citizens.index')
            ->with('success', 'Akun masyarakat berhasil dihapus.');
    }
}
