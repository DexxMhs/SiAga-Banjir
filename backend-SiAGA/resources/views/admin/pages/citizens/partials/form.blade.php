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
        <label class="flex flex-col gap-2 col-span-2">
            <span class="text-sm font-medium text-gray-700 dark:text-white">Nama Lengkap <span
                    class="text-red-500">*</span></span>
            <input name="name" value="{{ old('name', $citizen->name ?? ($citizen ?? '')) }}" required
                class="form-input w-full rounded-lg border-gray-300 bg-gray-50 text-gray-900 placeholder:text-gray-400 focus:border-primary focus:ring-primary dark:border-[#3a3e55] dark:bg-[#111218] dark:text-white dark:placeholder:text-[#9ba0bb] h-12 px-4 transition-colors"
                placeholder="Contoh: Budi Santoso" type="text" />
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
            <span class="text-sm font-medium text-gray-700 dark:text-white">Wilayah Tinggal <span
                    class="text-red-500">*</span></span>
            <div class="relative">
                <select name="region_id"
                    class="w-full appearance-none rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-gray-900 focus:border-primary focus:ring-primary dark:border-[#3a3e55] dark:bg-[#111218] dark:text-white transition-colors">

                    <option value="">-- Pilih Wilayah --</option>

                    @foreach ($regions as $region)
                        <option value="{{ $region->id }}" {{-- LOGIKA UTAMA DI SINI --}}
                            {{ old('region_id', $citizen->region_id ?? '') == $region->id ? 'selected' : '' }}>
                            {{ $region->name }}
                        </option>
                    @endforeach
                </select>

                {{-- Ikon Panah Dropdown (Opsional agar lebih cantik) --}}
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                    <span class="material-symbols-outlined text-[20px]">expand_more</span>
                </div>
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
            <input name="username" value="{{ old('username', $citizen->username ?? ($citizen ?? '')) }}" required
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
                <input name="email" value="{{ old('email', $citizen->email ?? ($citizen ?? '')) }}" required
                    class="form-input w-full rounded-lg border-gray-300 bg-gray-50 text-gray-900 placeholder:text-gray-400 focus:border-primary focus:ring-primary dark:border-[#3a3e55] dark:bg-[#111218] dark:text-white dark:placeholder:text-[#9ba0bb] h-12 pl-11 pr-4 transition-colors"
                    placeholder="petugas@sistembanjir.id" type="email" />
            </div>
        </label>
        <!-- Password -->
        <label class="flex flex-col gap-2">
            <span class="text-sm font-medium text-gray-700 dark:text-white">Kata Sandi
                @if (!isset($citizen))
                    <span class="text-red-500">*</span>
                @endif
            </span>
            <div class="relative">
                <span
                    class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 dark:text-[#9ba0bb] material-symbols-outlined text-[20px]">lock</span>
                <input name="password" {{ isset($citizen) ? '' : 'required' }}
                    class="form-input w-full rounded-lg border-gray-300 bg-gray-50 text-gray-900 placeholder:text-gray-400 focus:border-primary focus:ring-primary dark:border-[#3a3e55] dark:bg-[#111218] dark:text-white dark:placeholder:text-[#9ba0bb] h-12 pl-11 pr-4 transition-colors"
                    placeholder="••••••••" type="password" />
            </div>
        </label>
        <!-- Confirm Password -->
        <label class="flex flex-col gap-2">
            <span class="text-sm font-medium text-gray-700 dark:text-white">Konfirmasi Kata
                Sandi
                @if (!isset($citizen))
                    <span class="text-red-500">*</span>
                @endif
            </span>
            <div class="relative">
                <span
                    class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 dark:text-[#9ba0bb] material-symbols-outlined text-[20px]">lock_reset</span>
                <input name="password_confirmation" {{ isset($citizen) ? '' : 'required' }}
                    class="form-input w-full rounded-lg border-gray-300 bg-gray-50 text-gray-900 placeholder:text-gray-400 focus:border-primary focus:ring-primary dark:border-[#3a3e55] dark:bg-[#111218] dark:text-white dark:placeholder:text-[#9ba0bb] h-12 pl-11 pr-4 transition-colors"
                    placeholder="••••••••" type="password" />
            </div>
        </label>
    </div>
</div>
