<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DisasterFacility; // Pastikan Model sudah dibuat
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DisasterFacilityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $type = $request->input('type');

        $facilities = DisasterFacility::query()
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('unique_code', 'like', "%{$search}%")
                    ->orWhere('address', 'like', "%{$search}%");
            })
            ->when($type, function ($query, $type) {
                $query->where('type', $type);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.pages.disaster_facilities.index', compact('facilities'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.disaster_facilities.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validasi Input
        $validated = $request->validate([
            'name'      => 'required|string|max:255',
            'type'      => 'required|in:pengungsian,dapur_umum,posko_kesehatan,logistik',
            'status'    => 'required|in:buka,tutup,penuh',
            'address'   => 'required|string',
            'latitude'  => 'required|numeric',
            'longitude' => 'required|numeric',
            'photo'     => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Validasi file gambar
            'notes'     => 'nullable|string',
        ]);

        // 2. Generate Unique Code (Format: FAC-ACAK)
        $validated['unique_code'] = $this->generateUniqueCode($validated['type']);

        // 3. Handle Upload Foto
        if ($request->hasFile('photo')) {
            // Simpan ke storage/app/public/facilities
            $path = $request->file('photo')->store('facilities', 'public');
            $validated['photo_path'] = $path;
        }

        // 4. Simpan ke Database
        DisasterFacility::create($validated);

        return redirect()->route('disaster-facilities.index')
            ->with('success', 'Fasilitas bencana berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $facility = DisasterFacility::findOrFail($id);
        return view('admin.pages.disaster_facilities.show', compact('facility'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $facility = DisasterFacility::findOrFail($id);
        return view('admin.pages.disaster_facilities.edit', compact('facility'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $facility = DisasterFacility::findOrFail($id);

        $validated = $request->validate([
            'name'      => 'required|string|max:255',
            'type'      => 'required|in:pengungsian,dapur_umum,posko_kesehatan,logistik',
            'status'    => 'required|in:buka,tutup,penuh',
            'address'   => 'required|string',
            'latitude'  => 'required|numeric',
            'longitude' => 'required|numeric',
            'photo'     => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'notes'     => 'nullable|string',
        ]);

        // Handle Upload Foto Baru
        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada
            if ($facility->photo_path && Storage::disk('public')->exists($facility->photo_path)) {
                Storage::disk('public')->delete($facility->photo_path);
            }

            // Upload foto baru
            $path = $request->file('photo')->store('facilities', 'public');
            $validated['photo_path'] = $path;
        }

        $facility->update($validated);

        return redirect()->route('disaster-facilities.index')
            ->with('success', 'Data fasilitas berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $facility = DisasterFacility::findOrFail($id);

        // Hapus foto dari storage sebelum hapus data di DB
        if ($facility->photo_path && Storage::disk('public')->exists($facility->photo_path)) {
            Storage::disk('public')->delete($facility->photo_path);
        }

        $facility->delete();

        return redirect()->route('disaster-facilities.index')
            ->with('success', 'Fasilitas bencana berhasil dihapus.');
    }

    /**
     * Helper untuk generate kode unik
     */
    protected function generateUniqueCode($type)
    {
        // 1. Tentukan Prefix berdasarkan Tipe Fasilitas
        $prefix = match ($type) {
            'pengungsian' => 'PNG', // PeNGungsian
            'dapur_umum' => 'DPR',  // DaPuR
            'posko_kesehatan' => 'MED', // MEDis
            'logistik' => 'LOG',    // LOGistik
            default => 'FAC',       // FACility (Default)
        };

        // 2. Ambil Tahun Sekarang
        $year = date('Y');

        // 3. Generate sampai menemukan kode yang belum terpakai (Unik)
        do {
            // Random string 4 karakter kapital (angka/huruf)
            $random = strtoupper(Str::random(4));

            // Gabungkan formatnya
            $code = "{$prefix}-{$year}-{$random}";

            // Cek database, ulangi jika kebetulan ada yang sama
        } while (DisasterFacility::where('unique_code', $code)->exists());

        return $code;
    }
}
