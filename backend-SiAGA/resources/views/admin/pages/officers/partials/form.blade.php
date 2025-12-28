<!-- Section: Personal Info -->
<div class="p-6 md:p-8 border-b border-gray-200 dark:border-[#2a2e3b]">
    <div class="flex items-center gap-3 mb-6">
        <div class="p-2 rounded-lg bg-primary/10 dark:bg-primary/20 text-primary">
            <span class="material-symbols-outlined">person</span>
        </div>
        <h2 class="text-xl font-bold text-gray-900 dark:text-white">
            Informasi Pribadi
        </h2>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Name -->
        <label class="flex flex-col gap-2">
            <span class="text-sm font-medium text-gray-700 dark:text-white">Nama Lengkap <span
                    class="text-red-500">*</span></span>
            <input name="name" value="{{ old('name', $officer->name ?? ($officer ?? '')) }}" required
                class="form-input w-full rounded-lg border-gray-300 bg-gray-50 text-gray-900 placeholder:text-gray-400 focus:border-primary focus:ring-primary dark:border-[#3a3e55] dark:bg-[#111218] dark:text-white dark:placeholder:text-[#9ba0bb] h-12 px-4 transition-colors"
                placeholder="Contoh: Budi Santoso" type="text" />
        </label>
        <!-- ID Number -->
        <label class="flex flex-col gap-2">
            <span class="text-sm font-medium text-gray-700 dark:text-white">Nomor Identitas
                (NIK/NIP)</span>
            <input type="text" name="nomor_induk" {{-- LOGIKA UTAMA: --}} {{-- 1. Cek old input (jika validasi gagal) --}} {{-- 2. Cek data $officer (jika mode Edit) --}}
                {{-- 3. Cek data $nextNomorInduk (jika mode Create) --}} value="{{ old('nomor_induk', $officer->nomor_induk ?? ($nextNomorInduk ?? '')) }}"
                class="form-input w-full rounded-lg border-gray-300 bg-gray-200 text-gray-500 cursor-not-allowed
                       focus:border-gray-300 focus:ring-0
                       dark:border-[#3a3e55] dark:bg-[#15171e] dark:text-gray-500 h-12 px-4 transition-colors"
                {{-- Gunakan 'readonly' bukan 'disabled' agar data tetap terkirim saat submit (penting untuk validasi Edit) --}} readonly />

            <p class="text-xs text-gray-400">
                {{ isset($officer) ? 'Nomor induk bersifat permanen dan tidak dapat diubah.' : 'Digenerate otomatis oleh sistem.' }}
            </p>
        </label>
    </div>
</div>

<!-- Section: Assignment & Account -->
<div class="p-6 md:p-8 border-b border-gray-200 dark:border-[#2a2e3b]">
    <div class="flex items-center gap-3 mb-6">
        <div class="p-2 rounded-lg bg-primary/10 dark:bg-primary/20 text-primary">
            <span class="material-symbols-outlined">badge</span>
        </div>
        <h2 class="text-xl font-bold text-gray-900 dark:text-white">
            Wilayah
        </h2>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Assignment Area -->
        <label class="flex flex-col gap-2 md:col-span-2">
            <span class="text-sm font-medium text-gray-700 dark:text-white">Wilayah Tugas <span
                    class="text-red-500">*</span></span>
            <div class="relative">
                <select name="stations[]" multiple size="5"
                    class="form-multiselect w-full rounded-lg border-gray-300 bg-gray-50 text-gray-900 focus:border-primary focus:ring-primary dark:border-[#3a3e55] dark:bg-[#111218] dark:text-white p-2 transition-colors">
                    @foreach ($stations as $st)
                        <option value="{{ $st->id }}" class="p-2 mb-1 rounded hover:bg-primary/10 cursor-pointer"
                            {{ in_array($st->id, old('stations', $assignedStationIds ?? [])) ? 'selected' : '' }}>
                            📍 {{ $st->name }} ({{ $st->location }})
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
            <span class="material-symbols-outlined">lock</span>
        </div>
        <h2 class="text-xl font-bold text-gray-900 dark:text-white">
            Keamanan Akun
        </h2>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Username -->
        <label class="flex flex-col gap-2 col-span-full">
            <span class="text-sm font-medium text-gray-700 dark:text-white">Username <span
                    class="text-red-500">*</span></span>
            <input name="username" value="{{ old('username', $officer->username ?? ($officer ?? '')) }}" required
                class="form-input w-full rounded-lg border-gray-300 bg-gray-50 text-gray-900 placeholder:text-gray-400 focus:border-primary focus:ring-primary dark:border-[#3a3e55] dark:bg-[#111218] dark:text-white dark:placeholder:text-[#9ba0bb] h-12 px-4 transition-colors"
                placeholder="Contoh: Budi" type="text" />
        </label>
        <!-- Email -->
        <label class="flex flex-col gap-2 md:col-span-2">
            <span class="text-sm font-medium text-gray-700 dark:text-white">Email (untuk
                login) <span class="text-red-500">*</span></span>
            <div class="relative">
                <span
                    class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 dark:text-[#9ba0bb] material-symbols-outlined text-[20px]">mail</span>
                <input name="email" value="{{ old('email', $officer->email ?? ($officer ?? '')) }}" required
                    class="form-input w-full rounded-lg border-gray-300 bg-gray-50 text-gray-900 placeholder:text-gray-400 focus:border-primary focus:ring-primary dark:border-[#3a3e55] dark:bg-[#111218] dark:text-white dark:placeholder:text-[#9ba0bb] h-12 pl-11 pr-4 transition-colors"
                    placeholder="petugas@sistembanjir.id" type="email" />
            </div>
        </label>
        <!-- Password -->
        <label class="flex flex-col gap-2">
            <span class="text-sm font-medium text-gray-700 dark:text-white">Kata Sandi
                @if (!isset($officer))
                    <span class="text-red-500">*</span>
                @endif
            </span>
            <div class="relative">
                <span
                    class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 dark:text-[#9ba0bb] material-symbols-outlined text-[20px]">lock</span>
                <input name="password" {{ isset($officer) ? '' : 'required' }}
                    class="form-input w-full rounded-lg border-gray-300 bg-gray-50 text-gray-900 placeholder:text-gray-400 focus:border-primary focus:ring-primary dark:border-[#3a3e55] dark:bg-[#111218] dark:text-white dark:placeholder:text-[#9ba0bb] h-12 pl-11 pr-4 transition-colors"
                    placeholder="••••••••" type="password" />
            </div>
        </label>
        <!-- Confirm Password -->
        <label class="flex flex-col gap-2">
            <span class="text-sm font-medium text-gray-700 dark:text-white">Konfirmasi Kata
                Sandi
                @if (!isset($officer))
                    <span class="text-red-500">*</span>
                @endif
            </span>
            <div class="relative">
                <span
                    class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 dark:text-[#9ba0bb] material-symbols-outlined text-[20px]">lock_reset</span>
                <input name="password_confirmation" {{ isset($officer) ? '' : 'required' }}
                    class="form-input w-full rounded-lg border-gray-300 bg-gray-50 text-gray-900 placeholder:text-gray-400 focus:border-primary focus:ring-primary dark:border-[#3a3e55] dark:bg-[#111218] dark:text-white dark:placeholder:text-[#9ba0bb] h-12 pl-11 pr-4 transition-colors"
                    placeholder="••••••••" type="password" />
            </div>
        </label>
    </div>
</div>
