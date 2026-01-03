<div class="p-6 md:p-8 border-b border-gray-200 dark:border-[#2a2e3b]">
    <div class="flex items-center gap-3 mb-6">
        <div class="p-2 rounded-lg bg-primary/10 dark:bg-primary/20 text-primary">
            <span class="material-symbols-outlined">domain</span>
        </div>
        <h2 class="text-xl font-bold text-gray-900 dark:text-white">
            Informasi Fasilitas
        </h2>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <label class="flex flex-col gap-2">
            <span class="text-sm font-medium text-gray-700 dark:text-white">
                Nama Fasilitas <span class="text-red-500">*</span>
            </span>
            <input type="text" name="name" value="{{ old('name', $facility->name ?? '') }}" required
                class="form-input w-full rounded-lg border-gray-300 bg-gray-50 text-gray-900 placeholder:text-gray-400 focus:border-primary focus:ring-primary dark:border-[#3a3e55] dark:bg-[#111218] dark:text-white dark:placeholder:text-[#9ba0bb] h-12 px-4 transition-colors"
                placeholder="Contoh: Masjid Al-Makmur (Posko 1)" />
            @error('name')
                <span class="text-xs text-red-500">{{ $message }}</span>
            @enderror
        </label>

        <label class="flex flex-col gap-2">
            <span class="text-sm font-medium text-gray-700 dark:text-white">Kode Fasilitas</span>
            <input type="text" name="unique_code"
                value="{{ old('unique_code', $facility->unique_code ?? 'Auto-Generated') }}" readonly
                class="form-input w-full rounded-lg border-gray-300 bg-gray-200 text-gray-500 cursor-not-allowed focus:ring-0 dark:border-[#3a3e55] dark:bg-[#15171e] dark:text-gray-500 h-12 px-4 transition-colors" />
            <span class="text-xs text-gray-400">Kode dibuat otomatis oleh sistem saat disimpan.</span>
        </label>

        <label class="flex flex-col gap-2">
            <span class="text-sm font-medium text-gray-700 dark:text-white">
                Jenis Fasilitas <span class="text-red-500">*</span>
            </span>
            <select name="type" required
                class="form-select w-full rounded-lg border-gray-300 bg-gray-50 text-gray-900 focus:border-primary focus:ring-primary dark:border-[#3a3e55] dark:bg-[#111218] dark:text-white h-12 px-4 cursor-pointer">
                <option value="" disabled selected>-- Pilih Jenis --</option>
                <option value="pengungsian" {{ old('type', $facility->type ?? '') == 'pengungsian' ? 'selected' : '' }}>
                    Tempat Pengungsian</option>
                <option value="dapur_umum" {{ old('type', $facility->type ?? '') == 'dapur_umum' ? 'selected' : '' }}>
                    Dapur Umum</option>
                <option value="posko_kesehatan"
                    {{ old('type', $facility->type ?? '') == 'posko_kesehatan' ? 'selected' : '' }}>Posko Kesehatan
                </option>
                <option value="logistik" {{ old('type', $facility->type ?? '') == 'logistik' ? 'selected' : '' }}>Gudang
                    Logistik</option>
            </select>
            @error('type')
                <span class="text-xs text-red-500">{{ $message }}</span>
            @enderror
        </label>

        <label class="flex flex-col gap-2">
            <span class="text-sm font-medium text-gray-700 dark:text-white">
                Alamat Lengkap <span class="text-red-500">*</span>
            </span>
            <input type="text" name="address" value="{{ old('address', $facility->address ?? '') }}" required
                class="form-input w-full rounded-lg border-gray-300 bg-gray-50 text-gray-900 placeholder:text-gray-400 focus:border-primary focus:ring-primary dark:border-[#3a3e55] dark:bg-[#111218] dark:text-white dark:placeholder:text-[#9ba0bb] h-12 px-4 transition-colors"
                placeholder="Jl. Mawar No. 12, Kel. Bedahan" />
            @error('address')
                <span class="text-xs text-red-500">{{ $message }}</span>
            @enderror
        </label>
    </div>
</div>

<div class="p-6 md:p-8 border-b border-gray-200 dark:border-[#2a2e3b]">
    <div class="flex items-center gap-3 mb-6">
        <div class="p-2 rounded-lg bg-primary/10 dark:bg-primary/20 text-primary">
            <span class="material-symbols-outlined">map</span>
        </div>
        <h2 class="text-xl font-bold text-gray-900 dark:text-white">
            Titik Lokasi (Maps)
        </h2>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <label class="flex flex-col gap-2">
            <span class="text-sm font-medium text-gray-700 dark:text-white">
                Latitude <span class="text-red-500">*</span>
            </span>
            <input type="text" name="latitude" value="{{ old('latitude', $facility->latitude ?? '') }}" required
                class="form-input w-full rounded-lg border-gray-300 bg-gray-50 text-gray-900 placeholder:text-gray-400 focus:border-primary focus:ring-primary dark:border-[#3a3e55] dark:bg-[#111218] dark:text-white dark:placeholder:text-[#9ba0bb] h-12 px-4 transition-colors"
                placeholder="-6.xxxxxx" />
            @error('latitude')
                <span class="text-xs text-red-500">{{ $message }}</span>
            @enderror
        </label>

        <label class="flex flex-col gap-2">
            <span class="text-sm font-medium text-gray-700 dark:text-white">
                Longitude <span class="text-red-500">*</span>
            </span>
            <input type="text" name="longitude" value="{{ old('longitude', $facility->longitude ?? '') }}" required
                class="form-input w-full rounded-lg border-gray-300 bg-gray-50 text-gray-900 placeholder:text-gray-400 focus:border-primary focus:ring-primary dark:border-[#3a3e55] dark:bg-[#111218] dark:text-white dark:placeholder:text-[#9ba0bb] h-12 px-4 transition-colors"
                placeholder="106.xxxxxx" />
            @error('longitude')
                <span class="text-xs text-red-500">{{ $message }}</span>
            @enderror
        </label>

        <div class="col-span-full text-xs text-gray-500 dark:text-gray-400 flex gap-1 items-center">
            <span class="material-symbols-outlined text-[16px]">info</span>
            Gunakan Google Maps untuk menyalin titik koordinat (Klik kanan pada peta > Salin koordinat).
        </div>
    </div>
</div>

<div class="p-6 md:p-8">
    <div class="flex items-center gap-3 mb-6">
        <div class="p-2 rounded-lg bg-primary/10 dark:bg-primary/20 text-primary">
            <span class="material-symbols-outlined">settings_applications</span>
        </div>
        <h2 class="text-xl font-bold text-gray-900 dark:text-white">
            Status & Media
        </h2>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <label class="flex flex-col gap-2 col-span-full">
            <span class="text-sm font-medium text-slate-700 dark:text-slate-300">Status Operasional <span
                    class="text-red-500">*</span></span>
            <div class="flex flex-wrap gap-4 pt-2">
                {{-- Buka --}}
                <label
                    class="flex items-center gap-2 cursor-pointer bg-white dark:bg-[#15171e] border border-gray-200 dark:border-gray-700 rounded-lg p-3 hover:border-green-500 hover:bg-green-50 dark:hover:bg-green-900/10 transition-colors">
                    <input type="radio" name="status" value="buka"
                        class="h-4 w-4 border-slate-300 text-green-600 focus:ring-green-500 dark:border-slate-600 dark:bg-[#1b1d27]"
                        {{ old('status', $facility->status ?? 'buka') == 'buka' ? 'checked' : '' }} />
                    <span class="text-sm text-slate-700 dark:text-slate-300 font-medium">Buka / Tersedia</span>
                </label>

                {{-- Penuh --}}
                <label
                    class="flex items-center gap-2 cursor-pointer bg-white dark:bg-[#15171e] border border-gray-200 dark:border-gray-700 rounded-lg p-3 hover:border-orange-500 hover:bg-orange-50 dark:hover:bg-orange-900/10 transition-colors">
                    <input type="radio" name="status" value="penuh"
                        class="h-4 w-4 border-slate-300 text-orange-600 focus:ring-orange-500 dark:border-slate-600 dark:bg-[#1b1d27]"
                        {{ old('status', $facility->status ?? '') == 'penuh' ? 'checked' : '' }} />
                    <span class="text-sm text-slate-700 dark:text-slate-300 font-medium">Penuh</span>
                </label>

                {{-- Tutup --}}
                <label
                    class="flex items-center gap-2 cursor-pointer bg-white dark:bg-[#15171e] border border-gray-200 dark:border-gray-700 rounded-lg p-3 hover:border-slate-500 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                    <input type="radio" name="status" value="tutup"
                        class="h-4 w-4 border-slate-300 text-slate-600 focus:ring-slate-500 dark:border-slate-600 dark:bg-[#1b1d27]"
                        {{ old('status', $facility->status ?? '') == 'tutup' ? 'checked' : '' }} />
                    <span class="text-sm text-slate-700 dark:text-slate-300 font-medium">Tutup / Tidak Aktif</span>
                </label>
            </div>
            @error('status')
                <span class="text-xs text-red-500">{{ $message }}</span>
            @enderror
        </label>

        <label class="flex flex-col gap-2 col-span-full">
            <span class="text-sm font-medium text-gray-700 dark:text-white">Foto Lokasi (Opsional)</span>
            <input type="file" name="photo" accept="image/*"
                class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20 dark:text-gray-400 dark:file:bg-primary/20 dark:file:text-primary transition-all" />

            <p class="text-xs text-gray-400">Format: JPG, PNG, JPEG. Maksimal 2MB.</p>

            {{-- Preview jika Edit --}}
            @if (isset($facility) && $facility->photo_path)
                <div class="mt-2">
                    <p class="text-xs text-gray-500 mb-1">Foto Saat Ini:</p>
                    <img src="{{ asset('storage/' . $facility->photo_path) }}"
                        class="h-24 w-auto rounded-lg border border-gray-300 dark:border-gray-700 object-cover">
                </div>
            @endif
            @error('photo')
                <span class="text-xs text-red-500">{{ $message }}</span>
            @enderror
        </label>

        <label class="flex flex-col gap-2 col-span-full">
            <span class="text-sm font-medium text-gray-700 dark:text-white">Catatan Tambahan</span>
            <textarea name="notes" rows="3"
                class="form-input w-full rounded-lg border-gray-300 bg-gray-50 text-gray-900 placeholder:text-gray-400 focus:border-primary focus:ring-primary dark:border-[#3a3e55] dark:bg-[#111218] dark:text-white dark:placeholder:text-[#9ba0bb] p-4 transition-colors"
                placeholder="Contoh: Kapasitas max 200 orang, perlu bawa alas tidur sendiri.">{{ old('notes', $facility->notes ?? '') }}</textarea>
            @error('notes')
                <span class="text-xs text-red-500">{{ $message }}</span>
            @enderror
        </label>
    </div>
</div>
