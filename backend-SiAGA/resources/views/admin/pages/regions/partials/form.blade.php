<div class="p-6 md:p-8 border-b border-gray-200 dark:border-[#2a2e3b]">
    <div class="flex items-center gap-3 mb-6">
        <div class="p-2 rounded-lg bg-primary/10 dark:bg-primary/20 text-primary">
            <span class="material-symbols-outlined">location_city</span>
        </div>
        <h2 class="text-xl font-bold text-gray-900 dark:text-white">
            Informasi Wilayah
        </h2>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <label class="flex flex-col gap-2">
            <span class="text-sm font-medium text-gray-700 dark:text-white">
                Nama Wilayah <span class="text-red-500">*</span>
            </span>
            <input type="text" name="name" value="{{ old('name', $region->name ?? '') }}" required
                class="form-input w-full rounded-lg border-gray-300 bg-gray-50 text-gray-900 placeholder:text-gray-400 focus:border-primary focus:ring-primary dark:border-[#3a3e55] dark:bg-[#111218] dark:text-white dark:placeholder:text-[#9ba0bb] h-12 px-4 transition-colors"
                placeholder="Contoh: Kelurahan Bidara Cina" />
        </label>

        <label class="flex flex-col gap-2">
            <span class="text-sm font-medium text-gray-700 dark:text-white">
                Lokasi / Jalan Utama <span class="text-red-500">*</span>
            </span>
            <input type="text" name="location" value="{{ old('location', $region->location ?? '') }}" required
                class="form-input w-full rounded-lg border-gray-300 bg-gray-50 text-gray-900 placeholder:text-gray-400 focus:border-primary focus:ring-primary dark:border-[#3a3e55] dark:bg-[#111218] dark:text-white dark:placeholder:text-[#9ba0bb] h-12 px-4 transition-colors"
                placeholder="Contoh: Jl. Tanjung Lengkong, RW 07" />
        </label>
    </div>
</div>

<div class="p-6 md:p-8 border-b border-gray-200 dark:border-[#2a2e3b]">
    <div class="flex items-center gap-3 mb-6">
        <div class="p-2 rounded-lg bg-primary/10 dark:bg-primary/20 text-primary">
            <span class="material-symbols-outlined">map</span>
        </div>
        <h2 class="text-xl font-bold text-gray-900 dark:text-white">
            Titik Pusat Wilayah
        </h2>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <label class="flex flex-col gap-2">
            <span class="text-sm font-medium text-gray-700 dark:text-white">Latitude</span>
            <input type="text" name="latitude" value="{{ old('latitude', $region->latitude ?? '') }}"
                class="form-input w-full rounded-lg border-gray-300 bg-gray-50 text-gray-900 placeholder:text-gray-400 focus:border-primary focus:ring-primary dark:border-[#3a3e55] dark:bg-[#111218] dark:text-white dark:placeholder:text-[#9ba0bb] h-12 px-4 transition-colors"
                placeholder="-6.xxxxxx" />
        </label>

        <label class="flex flex-col gap-2">
            <span class="text-sm font-medium text-gray-700 dark:text-white">Longitude</span>
            <input type="text" name="longitude" value="{{ old('longitude', $region->longitude ?? '') }}"
                class="form-input w-full rounded-lg border-gray-300 bg-gray-50 text-gray-900 placeholder:text-gray-400 focus:border-primary focus:ring-primary dark:border-[#3a3e55] dark:bg-[#111218] dark:text-white dark:placeholder:text-[#9ba0bb] h-12 px-4 transition-colors"
                placeholder="106.xxxxxx" />
        </label>
    </div>
</div>

<div class="p-6 md:p-8 border-b border-gray-200 dark:border-[#2a2e3b]">
    <div class="flex items-center gap-3 mb-6">
        <div class="p-2 rounded-lg bg-primary/10 dark:bg-primary/20 text-primary">
            <span class="material-symbols-outlined">sensors</span>
        </div>
        <h2 class="text-xl font-bold text-gray-900 dark:text-white">
            Pos Pantau Terkait
        </h2>
    </div>

    <div class="grid grid-cols-1">
        <label class="flex flex-col gap-2">
            <span class="text-sm font-medium text-gray-700 dark:text-white">Pilih Pos Pantau (Multiple)</span>
            <div class="relative">
                <select name="stations[]" multiple size="5"
                    class="form-multiselect w-full rounded-lg border-gray-300 bg-gray-50 text-gray-900 focus:border-primary focus:ring-primary dark:border-[#3a3e55] dark:bg-[#111218] dark:text-white p-2 transition-colors">
                    @foreach ($stations as $station)
                        <option value="{{ $station->id }}" class="p-2 mb-1 rounded hover:bg-primary/10 cursor-pointer"
                            {{-- Logika: Cek apakah ID station ada di array old input atau relasi database --}}
                            {{ collect(old('stations', isset($region) ? $region->relatedStations->pluck('id')->toArray() : []))->contains($station->id) ? 'selected' : '' }}>
                            🌊 {{ $station->name }} ({{ $station->location }})
                        </option>
                    @endforeach
                </select>
                <p class="text-xs text-gray-500 mt-2 flex items-center gap-1">
                    <span class="material-symbols-outlined text-[14px]">keyboard</span>
                    Tahan tombol <b>Ctrl</b> (Windows) atau <b>Cmd</b> (Mac) untuk memilih lebih dari satu pos pantau.
                </p>
            </div>
        </label>
    </div>
</div>

<div class="p-6 md:p-8">
    <div class="flex items-center gap-3 mb-6">
        <div class="p-2 rounded-lg bg-primary/10 dark:bg-primary/20 text-primary">
            <span class="material-symbols-outlined">warning</span>
        </div>
        <h2 class="text-xl font-bold text-gray-900 dark:text-white">
            Status & Risiko Banjir
        </h2>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">


        <label class="flex flex-col gap-2 col-span-full">
            <span class="text-sm font-medium text-gray-700 dark:text-white">Foto Wilayah (Opsional)</span>
            <input type="file" name="photo" accept="image/*"
                class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20 dark:text-gray-400 dark:file:bg-primary/20 dark:file:text-primary transition-all" />

            <p class="text-xs text-gray-400">Format: JPG, PNG, JPEG. Maksimal 2MB.</p>

            {{-- Preview Foto Lama --}}
            @if (isset($region) && $region->photo)
                <div class="mt-2">
                    <p class="text-xs text-gray-500 mb-1">Foto Saat Ini:</p>
                    <img src="{{ asset('storage/' . $region->photo) }}"
                        class="h-24 w-auto rounded-lg border border-gray-300 dark:border-gray-700 object-cover">
                </div>
            @endif
        </label>

        <label class="flex flex-col gap-2 col-span-full">
            <span class="text-sm font-medium text-gray-700 dark:text-white">Catatan Risiko</span>
            <textarea name="risk_note" rows="3"
                class="form-input w-full rounded-lg border-gray-300 bg-gray-50 text-gray-900 placeholder:text-gray-400 focus:border-primary focus:ring-primary dark:border-[#3a3e55] dark:bg-[#111218] dark:text-white dark:placeholder:text-[#9ba0bb] p-4 transition-colors"
                placeholder="Contoh: Rawan banjir kiriman, area dataran rendah dekat bantaran sungai.">{{ old('risk_note', $region->risk_note ?? '') }}</textarea>
        </label>
    </div>
</div>
