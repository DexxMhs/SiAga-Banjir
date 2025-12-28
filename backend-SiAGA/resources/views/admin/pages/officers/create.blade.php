@extends('admin.layouts.app')

@section('content')
    <div class="flex h-screen w-full overflow-hidden">
        <!-- Sidebar Navigation -->
        <aside
            class="flex w-72 flex-col justify-between border-r border-gray-200 dark:border-[#2a2e3b] bg-white dark:bg-[#111218] flex-shrink-0 h-full overflow-y-auto">
            <div class="flex flex-col gap-4 p-4">
                <div class="flex items-center gap-3 px-2 py-3">
                    <div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-10"
                        data-alt="System Logo abstract blue water wave"
                        style="
            background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuC_t_G-fbeoU8chdF0MCxkE5Lpnr4y0aYznTPGR8E059ymB8lukEbKJNhvYq2Mtj3WUrySbBaBhC2ptlpKIsAB-T-_iqFVcSuG2tcvEC3RRRd3YybTqtRfiaWGOGfyB46OwLoHbkYsYMN926NkqDitqPBgjNgTH5EQGh60qDDdynxdZNRKpavCVXlk0hQpxoj-GRyn3jrfsGI9vVbwFOgF52jeGC7RVsu4d-FIM1pdQVNqravvWADjsyA1TkmUbz5FV3xXOWXCm5wDx');
          ">
                    </div>
                    <div class="flex flex-col">
                        <h1 class="text-base font-bold leading-normal text-gray-900 dark:text-white">
                            Sistem Banjir
                        </h1>
                        <p class="text-sm font-normal leading-normal text-gray-500 dark:text-[#9ba0bb]">
                            Admin Panel
                        </p>
                    </div>
                </div>
                <nav class="flex flex-col gap-2 mt-2">
                    <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-[#1b1d27] transition-colors group"
                        href="#">
                        <span
                            class="material-symbols-outlined text-gray-500 dark:text-gray-400 group-hover:text-primary transition-colors">dashboard</span>
                        <p class="text-sm font-medium leading-normal">Dashboard</p>
                    </a>
                    <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-[#1b1d27] transition-colors group"
                        href="#">
                        <span
                            class="material-symbols-outlined text-gray-500 dark:text-gray-400 group-hover:text-primary transition-colors">location_on</span>
                        <p class="text-sm font-medium leading-normal">
                            Manajemen Pos Pantau
                        </p>
                    </a>
                    <!-- Active State -->
                    <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg bg-primary/10 dark:bg-[#272a3a] text-primary dark:text-white border-l-4 border-primary"
                        href="#">
                        <span class="material-symbols-outlined text-primary dark:text-white fill-1">group</span>
                        <p class="text-sm font-medium leading-normal">
                            Manajemen Petugas
                        </p>
                    </a>
                    <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-[#1b1d27] transition-colors group"
                        href="#">
                        <span
                            class="material-symbols-outlined text-gray-500 dark:text-gray-400 group-hover:text-primary transition-colors">assignment</span>
                        <p class="text-sm font-medium leading-normal">Laporan Petugas</p>
                    </a>
                    <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-[#1b1d27] transition-colors group"
                        href="#">
                        <span
                            class="material-symbols-outlined text-gray-500 dark:text-gray-400 group-hover:text-primary transition-colors">campaign</span>
                        <p class="text-sm font-medium leading-normal">
                            Laporan Masyarakat
                        </p>
                    </a>
                    <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-[#1b1d27] transition-colors group"
                        href="#">
                        <span
                            class="material-symbols-outlined text-gray-500 dark:text-gray-400 group-hover:text-primary transition-colors">warning</span>
                        <p class="text-sm font-medium leading-normal">Potensi Banjir</p>
                    </a>
                    <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-[#1b1d27] transition-colors group"
                        href="#">
                        <span
                            class="material-symbols-outlined text-gray-500 dark:text-gray-400 group-hover:text-primary transition-colors">summarize</span>
                        <p class="text-sm font-medium leading-normal">Rekap Laporan</p>
                    </a>
                </nav>
            </div>
            <div class="p-4 border-t border-gray-200 dark:border-[#2a2e3b]">
                <button
                    class="flex w-full items-center gap-3 px-3 py-2 rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-[#1b1d27] transition-colors">
                    <span class="material-symbols-outlined">logout</span>
                    <span class="text-sm font-medium">Keluar</span>
                </button>
            </div>
        </aside>
        <!-- Main Content -->
        <main class="flex-1 flex flex-col h-full overflow-hidden relative">
            <!-- Top Navbar (User Profile) -->
            <header
                class="flex h-16 items-center justify-between border-b border-gray-200 dark:border-[#2a2e3b] bg-white dark:bg-[#111218] px-6 shrink-0">
                <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-[#9ba0bb]">
                    <span class="cursor-pointer hover:text-primary dark:hover:text-white transition-colors">Manajemen
                        Petugas</span>
                    <span class="material-symbols-outlined text-xs">chevron_right</span>
                    <span class="text-gray-900 dark:text-white font-medium">Tambah Baru</span>
                </div>
                <div class="flex items-center gap-4">
                    <button
                        class="relative rounded-full p-2 text-gray-500 hover:bg-gray-100 dark:text-[#9ba0bb] dark:hover:bg-[#272a3a] transition-colors">
                        <span class="material-symbols-outlined">notifications</span>
                        <div
                            class="absolute top-2 right-2 size-2 rounded-full bg-red-500 border-2 border-white dark:border-[#111218]">
                        </div>
                    </button>
                    <div class="flex items-center gap-3 pl-3 border-l border-gray-200 dark:border-[#2a2e3b]">
                        <div class="text-right hidden sm:block">
                            <p class="text-sm font-medium text-gray-900 dark:text-white">
                                Admin Pusat
                            </p>
                            <p class="text-xs text-gray-500 dark:text-[#9ba0bb]">
                                Administrator
                            </p>
                        </div>
                        <div class="h-9 w-9 rounded-full bg-gray-200 dark:bg-[#272a3a] bg-cover bg-center cursor-pointer ring-2 ring-transparent hover:ring-primary transition-all"
                            data-alt="User avatar portrait"
                            style="
              background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuAA5an4SKYhokFA0vvXKfgCKLpbT2sYxUo_XeRml41DDaaZ0z4VLshPfYlsq0pg00dBiQb9M_ae-9FtAvpypO74goLvl_mp2rV23prFA8_7eB_VsOdBR1sSZQ0nnxPdtDV16CQqa1S1bcVte1DCxGmntjKxnmLfpij-DwpkOl1N1YyHLl56Pef-A6s00U6sx3LiCZSESaJPUaIGUkDLRgp4-f4DTzQnPdJnX2PgXJi00E_G6quDFXBDvzWR3Mx8sJpLmoIh-x1P2naX');
            ">
                        </div>
                    </div>
                </div>
            </header>
            <!-- Scrollable Content -->
            <div class="flex-1 overflow-y-auto p-6 md:p-10">
                <div class="mx-auto max-w-5xl">
                    <!-- Page Heading -->
                    <div class="mb-8 flex flex-col gap-2">
                        <h1 class="text-3xl md:text-4xl font-black text-gray-900 dark:text-white tracking-tight">
                            Tambah Petugas Baru
                        </h1>
                        <p class="text-base text-gray-500 dark:text-[#9ba0bb]">
                            Isi formulir di bawah untuk mendaftarkan petugas lapangan baru
                            ke dalam sistem.
                        </p>
                    </div>
                    <!-- Form Card -->
                    <div
                        class="rounded-xl border border-gray-200 dark:border-[#2a2e3b] bg-white dark:bg-[#1b1d27] shadow-sm">
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
                                    <span class="text-sm font-medium text-gray-700 dark:text-white">Nama Lengkap</span>
                                    <input
                                        class="form-input w-full rounded-lg border-gray-300 bg-gray-50 text-gray-900 placeholder:text-gray-400 focus:border-primary focus:ring-primary dark:border-[#3a3e55] dark:bg-[#111218] dark:text-white dark:placeholder:text-[#9ba0bb] h-12 px-4 transition-colors"
                                        placeholder="Contoh: Budi Santoso" type="text" />
                                </label>
                                <!-- ID Number -->
                                <label class="flex flex-col gap-2">
                                    <span class="text-sm font-medium text-gray-700 dark:text-white">Nomor Identitas
                                        (NIK/NIP)</span>
                                    <input
                                        class="form-input w-full rounded-lg border-gray-300 bg-gray-50 text-gray-900 placeholder:text-gray-400 focus:border-primary focus:ring-primary dark:border-[#3a3e55] dark:bg-[#111218] dark:text-white dark:placeholder:text-[#9ba0bb] h-12 px-4 transition-colors"
                                        placeholder="16 digit nomor identitas" type="text" />
                                </label>
                                <!-- Phone -->
                                <label class="flex flex-col gap-2">
                                    <span class="text-sm font-medium text-gray-700 dark:text-white">Nomor Telepon</span>
                                    <div class="relative">
                                        <span
                                            class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 dark:text-[#9ba0bb] material-symbols-outlined text-[20px]">call</span>
                                        <input
                                            class="form-input w-full rounded-lg border-gray-300 bg-gray-50 text-gray-900 placeholder:text-gray-400 focus:border-primary focus:ring-primary dark:border-[#3a3e55] dark:bg-[#111218] dark:text-white dark:placeholder:text-[#9ba0bb] h-12 pl-11 pr-4 transition-colors"
                                            placeholder="0812-xxxx-xxxx" type="tel" />
                                    </div>
                                </label>
                                <!-- Address/Location (Optional) -->
                                <label class="flex flex-col gap-2">
                                    <span class="text-sm font-medium text-gray-700 dark:text-white">Alamat
                                        Domisili</span>
                                    <input
                                        class="form-input w-full rounded-lg border-gray-300 bg-gray-50 text-gray-900 placeholder:text-gray-400 focus:border-primary focus:ring-primary dark:border-[#3a3e55] dark:bg-[#111218] dark:text-white dark:placeholder:text-[#9ba0bb] h-12 px-4 transition-colors"
                                        placeholder="Kota/Kabupaten" type="text" />
                                </label>
                            </div>
                        </div>
                        <!-- Section: Assignment & Account -->
                        <div class="p-6 md:p-8">
                            <div class="flex items-center gap-3 mb-6">
                                <div class="p-2 rounded-lg bg-primary/10 dark:bg-primary/20 text-primary">
                                    <span class="material-symbols-outlined">badge</span>
                                </div>
                                <h2 class="text-xl font-bold text-gray-900 dark:text-white">
                                    Wilayah &amp; Akun
                                </h2>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Assignment Area -->
                                <label class="flex flex-col gap-2 md:col-span-2">
                                    <span class="text-sm font-medium text-gray-700 dark:text-white">Wilayah
                                        Tugas</span>
                                    <select
                                        class="form-select w-full rounded-lg border-gray-300 bg-gray-50 text-gray-900 focus:border-primary focus:ring-primary dark:border-[#3a3e55] dark:bg-[#111218] dark:text-white h-12 px-4 transition-colors">
                                        <option disabled="" selected="" value="">
                                            Pilih wilayah tugas...
                                        </option>
                                        <option value="utara">Jakarta Utara - Sektor A</option>
                                        <option value="selatan">
                                            Jakarta Selatan - Sektor B
                                        </option>
                                        <option value="timur">Jakarta Timur - Sektor C</option>
                                        <option value="barat">Jakarta Barat - Sektor D</option>
                                        <option value="pusat">Jakarta Pusat - Sektor E</option>
                                    </select>
                                </label>
                                <!-- Email -->
                                <label class="flex flex-col gap-2 md:col-span-2">
                                    <span class="text-sm font-medium text-gray-700 dark:text-white">Email (untuk
                                        login)</span>
                                    <div class="relative">
                                        <span
                                            class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 dark:text-[#9ba0bb] material-symbols-outlined text-[20px]">mail</span>
                                        <input
                                            class="form-input w-full rounded-lg border-gray-300 bg-gray-50 text-gray-900 placeholder:text-gray-400 focus:border-primary focus:ring-primary dark:border-[#3a3e55] dark:bg-[#111218] dark:text-white dark:placeholder:text-[#9ba0bb] h-12 pl-11 pr-4 transition-colors"
                                            placeholder="petugas@sistembanjir.id" type="email" />
                                    </div>
                                </label>
                                <!-- Password -->
                                <label class="flex flex-col gap-2">
                                    <span class="text-sm font-medium text-gray-700 dark:text-white">Kata Sandi</span>
                                    <div class="relative">
                                        <span
                                            class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 dark:text-[#9ba0bb] material-symbols-outlined text-[20px]">lock</span>
                                        <input
                                            class="form-input w-full rounded-lg border-gray-300 bg-gray-50 text-gray-900 placeholder:text-gray-400 focus:border-primary focus:ring-primary dark:border-[#3a3e55] dark:bg-[#111218] dark:text-white dark:placeholder:text-[#9ba0bb] h-12 pl-11 pr-4 transition-colors"
                                            placeholder="••••••••" type="password" />
                                    </div>
                                </label>
                                <!-- Confirm Password -->
                                <label class="flex flex-col gap-2">
                                    <span class="text-sm font-medium text-gray-700 dark:text-white">Konfirmasi Kata
                                        Sandi</span>
                                    <div class="relative">
                                        <span
                                            class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 dark:text-[#9ba0bb] material-symbols-outlined text-[20px]">lock_reset</span>
                                        <input
                                            class="form-input w-full rounded-lg border-gray-300 bg-gray-50 text-gray-900 placeholder:text-gray-400 focus:border-primary focus:ring-primary dark:border-[#3a3e55] dark:bg-[#111218] dark:text-white dark:placeholder:text-[#9ba0bb] h-12 pl-11 pr-4 transition-colors"
                                            placeholder="••••••••" type="password" />
                                    </div>
                                </label>
                            </div>
                        </div>
                        <!-- Footer Actions -->
                        <div
                            class="p-6 bg-gray-50 dark:bg-[#222530] border-t border-gray-200 dark:border-[#2a2e3b] rounded-b-xl flex items-center justify-end gap-3">
                            <button
                                class="px-6 py-2.5 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-[#2a2e3b] transition-colors"
                                type="button">
                                Batal
                            </button>
                            <button
                                class="px-6 py-2.5 rounded-lg text-sm font-medium text-white bg-primary hover:bg-blue-700 shadow-lg shadow-primary/30 transition-all flex items-center gap-2"
                                type="button">
                                <span class="material-symbols-outlined text-[20px]">save</span>
                                Simpan Data
                            </button>
                        </div>
                    </div>
                </div>
                <!-- Footer -->
                <footer class="mt-12 mb-6 text-center">
                    <p class="text-sm text-gray-400 dark:text-gray-600">
                        © 2023 Sistem Monitoring Banjir. All rights reserved.
                    </p>
                </footer>
            </div>
        </main>
    </div>
@endsection
