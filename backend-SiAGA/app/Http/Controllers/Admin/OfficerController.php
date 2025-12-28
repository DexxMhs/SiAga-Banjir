<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Station;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class OfficerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $stationId = $request->input('station_id');

        $officers = User::where('role', 'petugas')
            ->with('assignedStations:id,name')
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('username', 'like', "%{$search}%")
                        ->orWhere('nomor_induk', 'like', "%{$search}%"); // Update search ke nomor_induk
                });
            })
            ->when($stationId, function ($query, $stationId) {
                $query->whereHas('assignedStations', function ($q) use ($stationId) {
                    $q->where('stations.id', $stationId);
                });
            })
            ->latest()
            ->paginate(5)
            ->withQueryString();

        $stats = [
            'total' => User::where('role', 'petugas')->count(),
            'assigned' => User::where('role', 'petugas')->whereHas('assignedStations')->count(),
            'unassigned' => User::where('role', 'petugas')->whereDoesntHave('assignedStations')->count(),
        ];

        $stations = Station::select('id', 'name')->get();

        return view('admin.pages.officers.index', compact('officers', 'stats', 'stations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $stations = Station::all();
        // Kita kirim calon nomor induk ke view (opsional, hanya untuk display)
        $nextNomorInduk = $this->generateNomorInduk();

        return view('admin.pages.officers.create', compact('stations', 'nextNomorInduk'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validasi Input (Nomor Induk TIDAK divalidasi dari request karena otomatis)
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'username' => 'required|string|unique:users,username|max:50',
            'password' => 'required|string|min:8|confirmed', // Ada konfirmasi password
            'stations' => 'nullable|array',
            'stations.*' => 'exists:stations,id',
        ]);

        // 2. Generate Nomor Induk Otomatis
        $validated['nomor_induk'] = $this->generateNomorInduk();

        // 3. Setup data lainnya
        $validated['password'] = Hash::make($validated['password']);
        $validated['role'] = 'petugas';

        // 4. Simpan User
        $user = User::create($validated);

        // 5. Simpan Relasi Stasiun
        if ($request->has('stations')) {
            $user->assignedStations()->sync($request->stations);
        }

        return redirect()->route('officers.index')
            ->with('success', "Petugas berhasil ditambahkan dengan Nomor Induk: {$user->nomor_induk}");
    }

    /**
     * Fungsi Private untuk Generate Nomor Induk
     * Format: PTG-YYYYMMDD-XXX (Contoh: PTG-20251228-001)
     */
    private function generateNomorInduk()
    {
        $prefix = 'PTG-' . date('Ymd') . '-';

        // Cari user terakhir yang punya prefix hari ini
        $lastUser = User::where('nomor_induk', 'like', $prefix . '%')
            ->orderBy('nomor_induk', 'desc')
            ->first();

        if (!$lastUser) {
            $number = '001';
        } else {
            // Ambil 3 digit terakhir
            $lastNumber = intval(substr($lastUser->nomor_induk, -3));
            // Tambah 1 dan pad dengan nol di kiri (misal 1 jadi 001)
            $number = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
        }

        return $prefix . $number;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $officer = User::where('role', 'petugas')->with('assignedStations')->findOrFail($id);
        return view('admin.pages.officers.show', compact('officer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $officer = User::where('role', 'petugas')->findOrFail($id);
        $stations = Station::all();
        $assignedStationIds = $officer->assignedStations->pluck('id')->toArray();

        return view('admin.pages.officers.edit', compact('officer', 'stations', 'assignedStationIds'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $officer = User::where('role', 'petugas')->findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nomor_induk' => ['required', 'string', 'max:20', Rule::unique('users')->ignore($officer->id)],
            'email' => ['required', 'email', Rule::unique('users')->ignore($officer->id)],
            'username' => ['required', 'string', 'max:50', Rule::unique('users')->ignore($officer->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'stations' => 'nullable|array',
            'stations.*' => 'exists:stations,id',
            // Validasi Foto: Gambar, maks 800KB, format jpeg/png/jpg/gif
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:800',
        ]);

        // 1. Handle Password (seperti sebelumnya)
        if ($request->filled('password')) {
            $validated['password'] = Hash::make($request->password);
        } else {
            unset($validated['password']);
        }

        // 2. Handle Upload Foto
        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada (dan bukan default)
            if ($officer->photo && Storage::exists('public/' . $officer->photo)) {
                Storage::delete('public/' . $officer->photo);
            }
            // Simpan foto baru ke folder 'officers' di storage public
            $path = $request->file('photo')->store('officers', 'public');
            $validated['photo'] = $path;
        }

        // 3. Handle Hapus Foto (Jika user klik tombol hapus)
        if ($request->boolean('delete_photo_flag')) {
            if ($officer->photo && Storage::exists('public/' . $officer->photo)) {
                Storage::delete('public/' . $officer->photo);
            }
            $validated['photo'] = null;
        }

        $officer->update($validated);

        // Update Relasi Stasiun
        if ($request->has('stations')) {
            $officer->assignedStations()->sync($request->stations);
        } else {
            $officer->assignedStations()->detach();
        }

        return redirect()->route('officers.index')->with('success', 'Data petugas berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $officer = User::where('role', 'petugas')->findOrFail($id);
        $officer->assignedStations()->detach();
        $officer->delete();

        return redirect()->route('officers.index')->with('success', 'Petugas berhasil dihapus.');
    }
}
