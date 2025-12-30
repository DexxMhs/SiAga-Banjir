<!-- Section: Personal Info -->
<div class="p-6 md:p-8 border-b border-gray-200 dark:border-[#2a2e3b]">
    <div class="flex items-center gap-3 mb-6">
        <div class="p-2 rounded-lg bg-primary/10 dark:bg-primary/20 text-primary">
            <span class="material-symbols-outlined">info</span>
        </div>
        <h2 class="text-xl font-bold text-gray-900 dark:text-white">
            Informasi Dasar
        </h2>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-2">
        <!-- Name -->
        <label class="flex flex-col gap-2">
            <span class="text-sm font-medium text-gray-700 dark:text-white">Nama Pos Pantau <span
                    class="text-red-500">*</span></span>
            <input name="name" value="{{ old('name', $station->name ?? ($station ?? '')) }}" required
                class="form-input w-full rounded-lg border-gray-300 bg-gray-50 text-gray-900 placeholder:text-gray-400 focus:border-primary focus:ring-primary dark:border-[#3a3e55] dark:bg-[#111218] dark:text-white dark:placeholder:text-[#9ba0bb] h-12 px-4 transition-colors"
                placeholder="Contoh: Pos Pantau Katulampa" type="text" />
        </label>
        <!-- ID Number -->
        <label class="flex flex-col gap-2">
            <span class="text-sm font-medium text-gray-700 dark:text-white">Kode Pos Pantau</span>
            <input type="text" name="station_code" {{-- LOGIKA UTAMA: --}} {{-- 1. Cek old input (jika validasi gagal) --}} {{-- 2. Cek data $station (jika mode Edit) --}}
                {{-- 3. Cek data $nextNomorInduk (jika mode Create) --}}
                value="{{ old('station_code', $station->station_code ?? ($nextStationCode ?? '')) }}"
                class="form-input w-full rounded-lg border-gray-300 bg-gray-200 text-gray-500 cursor-not-allowed
                       focus:border-gray-300 focus:ring-0
                       dark:border-[#3a3e55] dark:bg-[#15171e] dark:text-gray-500 h-12 px-4 transition-colors"
                {{-- Gunakan 'readonly' bukan 'disabled' agar data tetap terkirim saat submit (penting untuk validasi Edit) --}} readonly />

            <p class="text-xs text-gray-400">
                {{ isset($station) ? 'Kode pos pantau bersifat permanen dan tidak dapat diubah.' : 'Digenerate otomatis oleh sistem.' }}
            </p>
        </label>

        <label class="flex flex-col gap-2 col-span-full">
            <span class="text-sm font-medium text-gray-700 dark:text-white">Lokasi <span
                    class="text-red-500">*</span></span>
            <input name="location" value="{{ old('location', $station->location ?? ($station ?? '')) }}" required
                class="form-input w-full rounded-lg border-gray-300 bg-gray-50 text-gray-900 placeholder:text-gray-400 focus:border-primary focus:ring-primary dark:border-[#3a3e55] dark:bg-[#111218] dark:text-white dark:placeholder:text-[#9ba0bb] h-12 px-4 transition-colors"
                placeholder="Contoh: Depok" type="text" />
        </label>
    </div>
</div>

<!-- Section: Assignment & Account -->
<div class="p-6 md:p-8 border-b border-gray-200 dark:border-[#2a2e3b]">
    <div class="flex items-center gap-3 mb-6">
        <div class="p-2 rounded-lg bg-primary/10 dark:bg-primary/20 text-primary">
            <span class="material-symbols-outlined">map</span>
        </div>
        <h2 class="text-xl font-bold text-gray-900 dark:text-white">
            Lokasi Koordinat
        </h2>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <label class="flex flex-col gap-2 ">
            <span class="text-sm font-medium text-gray-700 dark:text-white">Latitude <span
                    class="text-red-500">*</span></span>
            <input name="latitude" value="{{ old('latitude', $station->latitude ?? ($station ?? '')) }}" required
                class="form-input w-full rounded-lg border-gray-300 bg-gray-50 text-gray-900 placeholder:text-gray-400 focus:border-primary focus:ring-primary dark:border-[#3a3e55] dark:bg-[#111218] dark:text-white dark:placeholder:text-[#9ba0bb] h-12 px-4 transition-colors"
                placeholder="Contoh: -6.123456" type="text" />
        </label>

        <label class="flex flex-col gap-2 ">
            <span class="text-sm font-medium text-gray-700 dark:text-white">Longitude <span
                    class="text-red-500">*</span></span>
            <input name="longitude" value="{{ old('longitude', $station->longitude ?? ($station ?? '')) }}" required
                class="form-input w-full rounded-lg border-gray-300 bg-gray-50 text-gray-900 placeholder:text-gray-400 focus:border-primary focus:ring-primary dark:border-[#3a3e55] dark:bg-[#111218] dark:text-white dark:placeholder:text-[#9ba0bb] h-12 px-4 transition-colors"
                placeholder="Contoh: 106.123456" type="text" />
        </label>
        <div
            class="col-span-2 rounded-lg bg-blue-50 p-3 dark:bg-primary/10 border border-blue-100 dark:border-primary/20 flex items-center gap-3 items-start">
            <span class="material-symbols-outlined text-primary text-sm">info</span>
            <p class="text-xs text-slate-600 dark:text-slate-300">
                Koordinat diperlukan untuk visualisasi peta sebaran
                banjir. Pastikan akurasi hingga 6 digit desimal.
            </p>
        </div>
    </div>
</div>

<!-- Section: Assignment & Account -->
<div class="p-6 md:p-8 border-b border-gray-200 dark:border-[#2a2e3b]">
    <div class="flex items-center gap-3 mb-6">
        <div class="p-2 rounded-lg bg-primary/10 dark:bg-primary/20 text-primary">
            <span class="material-symbols-outlined">map</span>
        </div>
        <h2 class="text-xl font-bold text-gray-900 dark:text-white">
            Wilayah yang Terdampak
        </h2>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <label class="flex flex-col gap-2 md:col-span-2">
            <span class="text-sm font-medium text-gray-700 dark:text-white">Wilayah Terdampak</span>
            <div class="relative">
                <select name="regions[]" multiple size="5"
                    class="form-multiselect w-full rounded-lg border-gray-300 bg-gray-50 text-gray-900 focus:border-primary focus:ring-primary dark:border-[#3a3e55] dark:bg-[#111218] dark:text-white p-2 transition-colors">
                    @foreach ($regions as $region)
                        <option value="{{ $region->id }}" class="p-2 mb-1 rounded hover:bg-primary/10 cursor-pointer"
                            {{ in_array($region->id, old('regions', $assignedRegionIds ?? [])) ? 'selected' : '' }}>
                            📍 {{ $region->name }} ({{ $region->location }})
                        </option>
                    @endforeach
                </select>
                <p class="text-xs text-gray-500 mt-1">💡 Tahan tombol <span
                        class="font-bold text-gray-700 dark:text-gray-300">Ctrl</span> (Windows)
                    atau <span class="font-bold text-gray-700 dark:text-gray-300">Command</span>
                    (Mac) untuk memilih lebih dari satu wilayah.</p>
            </div>
        </label>
    </div>
</div>

<!-- Section: Account Security -->
<div class="p-6 md:p-8">
    <div class="flex items-center gap-3 mb-6">
        <div class="p-2 rounded-lg bg-primary/10 dark:bg-primary/20 text-primary">
            <span class="material-symbols-outlined">settings</span>
        </div>
        <h2 class="text-xl font-bold text-gray-900 dark:text-white">
            Spesifikasi & Status
        </h2>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Ambang Batas Siaga -->
        <label class="flex flex-col gap-2 ">
            <span class="text-sm font-medium text-gray-700 dark:text-white">Ambang Batas Siaga <span
                    class="text-red-500">*</span></span>
            <input name="threshold_siaga"
                value="{{ old('threshold_siaga', $station->threshold_siaga ?? ($station ?? '')) }}" required
                class="form-input w-full rounded-lg border-gray-300 bg-gray-50 text-gray-900 placeholder:text-gray-400 focus:border-primary focus:ring-primary dark:border-[#3a3e55] dark:bg-[#111218] dark:text-white dark:placeholder:text-[#9ba0bb] h-12 px-4 transition-colors"
                placeholder="Contoh: 150" type="text" />
        </label>
        <!-- Ambang Batas Awas -->
        <label class="flex flex-col gap-2 ">
            <span class="text-sm font-medium text-gray-700 dark:text-white">Ambang Batas Awas <span
                    class="text-red-500">*</span></span>
            <input name="threshold_awas"
                value="{{ old('threshold_awas', $station->threshold_awas ?? ($station ?? '')) }}" required
                class="form-input w-full rounded-lg border-gray-300 bg-gray-50 text-gray-900 placeholder:text-gray-400 focus:border-primary focus:ring-primary dark:border-[#3a3e55] dark:bg-[#111218] dark:text-white dark:placeholder:text-[#9ba0bb] h-12 px-4 transition-colors"
                placeholder="Contoh: 150" type="text" />
        </label>

        <label class="flex flex-col gap-1.5 col-span-2 md:col-span-1">
            <span class="text-sm font-medium text-slate-700 dark:text-slate-300">Status Operasional</span>

            <div class="flex gap-4 pt-2">
                {{-- Pilihan 1: Aktif --}}
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="radio" name="operational_status" value="active"
                        class="h-4 w-4 border-slate-300 text-primary focus:ring-primary dark:border-slate-600 dark:bg-[#1b1d27]"
                        {{-- Logika: Cek old input -> Cek database -> Default 'active' --}}
                        {{ old('operational_status', $station->operational_status ?? 'active') == 'active' ? 'checked' : '' }} />
                    <span class="text-sm text-slate-700 dark:text-slate-300">Aktif</span>
                </label>

                {{-- Pilihan 2: Maintenance --}}
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="radio" name="operational_status" value="maintenance"
                        class="h-4 w-4 border-slate-300 text-primary focus:ring-primary dark:border-slate-600 dark:bg-[#1b1d27]"
                        {{ old('operational_status', $station->operational_status ?? '') == 'maintenance' ? 'checked' : '' }} />
                    <span class="text-sm text-slate-700 dark:text-slate-300">Maintenance</span>
                </label>

                {{-- Pilihan 3: Non-Aktif --}}
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="radio" name="operational_status" value="non-active"
                        class="h-4 w-4 border-slate-300 text-primary focus:ring-primary dark:border-slate-600 dark:bg-[#1b1d27]"
                        {{ old('operational_status', $station->operational_status ?? '') == 'non-active' ? 'checked' : '' }} />
                    <span class="text-sm text-slate-700 dark:text-slate-300">Non-Aktif</span>
                </label>
            </div>
        </label>

        <label class="flex flex-col gap-2 col-span-full">
            <span class="text-sm font-medium text-gray-700 dark:text-white">Keterangan Tambahan</span>
            <textarea name="description" value="{{ old('description', $station->description ?? ($station ?? '')) }}"
                class="form-input w-full rounded-lg border-gray-300 bg-gray-50 text-gray-900 placeholder:text-gray-400 focus:border-primary focus:ring-primary dark:border-[#3a3e55] dark:bg-[#111218] dark:text-white dark:placeholder:text-[#9ba0bb] px-4 transition-colors"
                placeholder="Catatan mengenai kondisi pos, akses jalan, atau kontak penjaga pos" type="text" rows="3"></textarea>
        </label>
    </div>
</div>
