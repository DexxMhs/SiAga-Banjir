<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Region;
use App\Models\Station;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Exports\RegionsExport;
use Maatwebsite\Excel\Facades\Excel;

class RegionController extends Controller
{
    /**
     * Menampilkan daftar wilayah.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');

        $regions = Region::withCount('users') // Hitung jumlah warga
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%");
            })
            ->when($status, function ($query, $status) {
                return $query->where('flood_status', $status);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.pages.regions.index', compact('regions'));
    }

    /**
     * Form tambah wilayah baru.
     */
    public function create()
    {
        // Ambil data stations untuk dihubungkan (Relasi Many-to-Many)
        $stations = Station::all();

        return view('admin.pages.regions.create', compact('stations'));
    }

    /**
     * Simpan data wilayah baru.
     */
    public function store(Request $request)
    {
        // 1. Validasi
        $validated = $request->validate([
            'name'         => 'required|string|max:255',
            'location'     => 'nullable|string|max:255',
            'latitude'     => 'nullable|numeric',
            'longitude'    => 'nullable|numeric',
            // 'flood_status' => 'required|in:normal,siaga,awas',
            'risk_note'    => 'nullable|string',
            'photo'        => 'nullable|image|mimes:jpeg,png,jpg|max:2048',

            // Validasi Array ID Stations (untuk pivot table)
            'stations'     => 'nullable|array',
            'stations.*'   => 'exists:stations,id',
        ]);

        // 2. Upload Foto (Jika ada)
        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('regions', 'public');
        }

        // 3. Simpan Data Region
        $region = Region::create($validated);

        // 4. Simpan Relasi Stasiun (Many-to-Many)
        if ($request->has('stations')) {
            $region->relatedStations()->attach($request->stations);
        }

        return redirect()->route('regions.index')
            ->with('success', 'Wilayah berhasil ditambahkan.');
    }

    /**
     * Tampilkan detail wilayah.
     */
    public function show(string $id)
    {
        // Load relasi stations dan users
        $region = Region::with(['relatedStations', 'users'])->findOrFail($id);

        return view('admin.pages.regions.show', compact('region'));
    }

    /**
     * Form edit wilayah.
     */
    public function edit(string $id)
    {
        $region = Region::with('relatedStations')->findOrFail($id);
        $stations = Station::all(); // Untuk pilihan checkbox/select

        return view('admin.pages.regions.edit', compact('region', 'stations'));
    }

    /**
     * Update data wilayah.
     */
    public function update(Request $request, string $id)
    {
        $region = Region::findOrFail($id);

        // 1. Validasi
        $validated = $request->validate([
            'name'         => 'required|string|max:255',
            'location'     => 'nullable|string|max:255',
            'latitude'     => 'nullable|numeric',
            'longitude'    => 'nullable|numeric',
            // 'flood_status' => 'required|in:normal,siaga,awas',
            'risk_note'    => 'nullable|string',
            'photo'        => 'nullable|image|mimes:jpeg,png,jpg|max:2048',

            'stations'     => 'nullable|array',
            'stations.*'   => 'exists:stations,id',
        ]);

        // 2. Cek Upload Foto Baru
        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada di storage
            if ($region->photo && Storage::disk('public')->exists($region->photo)) {
                Storage::disk('public')->delete($region->photo);
            }
            // Simpan foto baru
            $validated['photo'] = $request->file('photo')->store('regions', 'public');
        }

        // 3. Update Data Region
        $region->update($validated);

        // 4. Update Relasi Stasiun (Sync)
        // Sync akan otomatis menghapus yang tidak dicentang dan menambah yang baru
        $region->relatedStations()->sync($request->input('stations', []));

        return redirect()->route('regions.index')
            ->with('success', 'Data wilayah berhasil diperbarui.');
    }

    /**
     * Hapus wilayah.
     */
    public function destroy(string $id)
    {
        $region = Region::findOrFail($id);

        // 1. Hapus Foto dari Storage
        if ($region->photo && Storage::disk('public')->exists($region->photo)) {
            Storage::disk('public')->delete($region->photo);
        }

        // 2. Hapus Data (Relasi pivot akan terhapus otomatis atau via cascade di database)
        $region->delete();

        return redirect()->route('regions.index')
            ->with('success', 'Wilayah berhasil dihapus.');
    }

    public function export(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');

        // Nama file dengan timestamp agar unik
        $fileName = 'laporan-data-wilayah-' . now()->format('Y-m-d_H-i') . '.xlsx';

        return Excel::download(new RegionsExport($search, $status), $fileName);
    }
}
