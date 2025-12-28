<!DOCTYPE html>

<html class="dark" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Rekapitulasi &amp; Laporan - Flood Monitor Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@400;500;600;700;900&amp;display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        primary: "#607afb",
                        "background-light": "#f5f6f8",
                        "background-dark": "#0f1323",
                        "surface-dark": "#1a1f33",
                        "surface-dark-highlight": "#252b42",
                        "text-secondary": "#9ba0bb",
                    },
                    fontFamily: {
                        display: ["Public Sans", "sans-serif"],
                    },
                    borderRadius: {
                        DEFAULT: "0.25rem",
                        lg: "0.5rem",
                        xl: "0.75rem",
                        full: "9999px",
                    },
                },
            },
        };
    </script>
    <style>
        /* Custom scrollbar for better look in dark mode */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #0f1323;
        }

        ::-webkit-scrollbar-thumb {
            background: #33394f;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #474f6b;
        }
    </style>
</head>

<body
    class="bg-background-light dark:bg-background-dark text-slate-900 dark:text-white font-display antialiased selection:bg-primary selection:text-white">
    <div class="flex h-screen w-full overflow-hidden">
        <!-- Sidebar -->
        <aside class="flex w-72 flex-col bg-surface-dark border-r border-white/5 h-full flex-shrink-0">
            <div class="p-6 flex items-center gap-3 border-b border-white/5">
                <div class="bg-center bg-no-repeat bg-cover rounded-full size-10 shadow-lg ring-2 ring-white/10"
                    data-alt="Abstract water wave logo gradient blue"
                    style="
              background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuCrN_uUm-V34bidOUL8exBExCemGmuUBSVbtjJiXlO9WWc7MTQsPhAZdv3xXcdYCo6L-0Os-2_cSFa6EJtMKmYwseEN-0a9p2NOTdG9OwEfIBNoBkRIU_Ol60yU8jmADXL2u59qcc62wK6voc9Q-cI08PnbpLcPVBHfZWUO5gz8XyM3lLsndEcH-zoDNn0dI2cHpkIKDqA_BHK0JSC1wwxRKaZmcWekmv11rXXIYDiL0liOm26DlD_8t-DNl_D1mETr_V8MCBezaxPs');
            ">
                </div>
                <div class="flex flex-col">
                    <h1 class="text-white text-base font-bold leading-none">
                        Flood Monitor
                    </h1>
                    <p class="text-text-secondary text-xs font-normal mt-1">
                        Admin Panel
                    </p>
                </div>
            </div>
            <nav class="flex-1 overflow-y-auto px-4 py-6 flex flex-col gap-2">
                <!-- Navigation Items -->
                <a class="flex items-center gap-3 px-3 py-3 rounded-lg text-text-secondary hover:bg-white/5 transition-colors group"
                    href="#">
                    <span class="material-symbols-outlined group-hover:text-white transition-colors">dashboard</span>
                    <span class="text-sm font-medium group-hover:text-white transition-colors">Dashboard</span>
                </a>
                <a class="flex items-center gap-3 px-3 py-3 rounded-lg text-text-secondary hover:bg-white/5 transition-colors group"
                    href="#">
                    <span class="material-symbols-outlined group-hover:text-white transition-colors">water_lux</span>
                    <span class="text-sm font-medium group-hover:text-white transition-colors">Manajemen Pos
                        Pantau</span>
                </a>
                <a class="flex items-center gap-3 px-3 py-3 rounded-lg text-text-secondary hover:bg-white/5 transition-colors group"
                    href="#">
                    <span class="material-symbols-outlined group-hover:text-white transition-colors">badge</span>
                    <span class="text-sm font-medium group-hover:text-white transition-colors">Manajemen Petugas</span>
                </a>
                <a class="flex items-center gap-3 px-3 py-3 rounded-lg text-text-secondary hover:bg-white/5 transition-colors group"
                    href="#">
                    <span
                        class="material-symbols-outlined group-hover:text-white transition-colors">assignment_ind</span>
                    <span class="text-sm font-medium group-hover:text-white transition-colors">Laporan Petugas</span>
                </a>
                <a class="flex items-center gap-3 px-3 py-3 rounded-lg text-text-secondary hover:bg-white/5 transition-colors group"
                    href="#">
                    <span class="material-symbols-outlined group-hover:text-white transition-colors">forum</span>
                    <span class="text-sm font-medium group-hover:text-white transition-colors">Laporan Masyarakat</span>
                </a>
                <a class="flex items-center gap-3 px-3 py-3 rounded-lg text-text-secondary hover:bg-white/5 transition-colors group"
                    href="#">
                    <span class="material-symbols-outlined group-hover:text-white transition-colors">warning</span>
                    <span class="text-sm font-medium group-hover:text-white transition-colors">Potensi Banjir</span>
                </a>
                <!-- Active State -->
                <a class="flex items-center gap-3 px-3 py-3 rounded-lg bg-primary text-white shadow-lg shadow-primary/20"
                    href="#">
                    <span class="material-symbols-outlined fill-1">description</span>
                    <span class="text-sm font-medium">Rekap Laporan</span>
                </a>
            </nav>
            <div class="p-4 border-t border-white/5">
                <button
                    class="flex items-center gap-3 px-3 py-2 w-full rounded-lg text-text-secondary hover:text-red-400 hover:bg-red-400/10 transition-colors">
                    <span class="material-symbols-outlined">logout</span>
                    <span class="text-sm font-medium">Log Out</span>
                </button>
            </div>
        </aside>
        <!-- Main Content -->
        <main class="flex-1 flex flex-col h-full overflow-hidden relative">
            <!-- Top Header -->
            <header
                class="h-16 border-b border-white/5 bg-background-dark/50 backdrop-blur-md flex items-center justify-between px-8 flex-shrink-0 z-10 sticky top-0">
                <!-- Breadcrumbs -->
                <nav class="flex items-center gap-2">
                    <a class="text-text-secondary text-sm font-medium hover:text-white transition-colors"
                        href="#">Dashboard</a>
                    <span class="text-text-secondary text-sm">/</span>
                    <span class="text-white text-sm font-medium">Rekapitulasi &amp; Laporan</span>
                </nav>
                <!-- User Profile -->
                <div class="flex items-center gap-4">
                    <div class="flex flex-col items-end hidden md:flex">
                        <span class="text-white text-sm font-medium">Admin Pusat</span>
                        <span class="text-text-secondary text-xs">admin@floodmonitor.id</span>
                    </div>
                    <div class="relative">
                        <div class="size-10 rounded-full bg-cover bg-center cursor-pointer ring-2 ring-white/10 hover:ring-primary transition-all"
                            data-alt="Portrait of a user"
                            style="
                  background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuBsRJbKg2Y2O6bNXxnRnFlUEdW15oBlu3jOTC_cFSIMieEXz_bbD5imKLd8AxOnlK9VnZfqxkLEx7an2eX0tphQbC5JE7rkguRFZ2y2KUlr9EMAPO4_tTfycIMvQ2qUxL5Jfk-iKBtYHAHf7XPXiiyXajVomTJ3Jy-cEZeWhp5oZ7P0M86zsSqEWqu50zb-cL47FNGKrjCEviAoji_mr_GX-sb-ihl3fnLsI-s5oeC9X6OSSkAD5aVqX-pM-7J_iMMPkOQ1BsKDCa8S');
                ">
                        </div>
                        <div
                            class="absolute bottom-0 right-0 size-3 bg-emerald-500 border-2 border-background-dark rounded-full">
                        </div>
                    </div>
                </div>
            </header>
            <!-- Scrollable Content Area -->
            <div class="flex-1 overflow-y-auto p-8">
                <div class="max-w-[1200px] mx-auto space-y-8 pb-10">
                    <!-- Page Heading -->
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                        <div class="space-y-1">
                            <h1 class="text-3xl font-bold text-white tracking-tight">
                                Rekapitulasi Data
                            </h1>
                            <p class="text-text-secondary">
                                Analisis tren banjir dan unduh laporan statistik bulanan.
                            </p>
                        </div>
                        <div class="flex gap-3">
                            <button
                                class="bg-surface-dark border border-white/10 text-white px-4 py-2.5 rounded-lg text-sm font-medium hover:bg-surface-dark-highlight flex items-center gap-2 transition-colors">
                                <span class="material-symbols-outlined text-[20px]">file_download</span>
                                Export CSV
                            </button>
                            <button
                                class="bg-primary text-white px-4 py-2.5 rounded-lg text-sm font-medium hover:bg-blue-600 flex items-center gap-2 shadow-lg shadow-primary/25 transition-colors">
                                <span class="material-symbols-outlined text-[20px]">picture_as_pdf</span>
                                Unduh Laporan PDF
                            </button>
                        </div>
                    </div>
                    <!-- Filter Section -->
                    <section class="bg-surface-dark rounded-xl border border-white/5 p-5 shadow-xl">
                        <div class="flex items-center gap-2 mb-4">
                            <span class="material-symbols-outlined text-primary">filter_alt</span>
                            <h3 class="text-white font-semibold text-lg">Filter Laporan</h3>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                            <!-- Date Range -->
                            <div class="md:col-span-1">
                                <label class="block text-text-secondary text-sm font-medium mb-2">Periode Waktu</label>
                                <div class="relative">
                                    <input
                                        class="w-full bg-background-dark border border-white/10 text-white text-sm rounded-lg focus:ring-primary focus:border-primary block p-2.5 pl-10 h-11 placeholder-text-secondary/50"
                                        placeholder="Jan 01, 2023 - Jan 31, 2023" type="text" />
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span
                                            class="material-symbols-outlined text-text-secondary text-[20px]">date_range</span>
                                    </div>
                                </div>
                            </div>
                            <!-- Region -->
                            <div class="md:col-span-1">
                                <label class="block text-text-secondary text-sm font-medium mb-2">Wilayah Pos</label>
                                <div class="relative">
                                    <select
                                        class="w-full bg-background-dark border border-white/10 text-white text-sm rounded-lg focus:ring-primary focus:border-primary block p-2.5 h-11 appearance-none">
                                        <option>Semua Wilayah</option>
                                        <option>Jakarta Selatan</option>
                                        <option>Jakarta Timur</option>
                                        <option>Bogor Raya</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <span
                                            class="material-symbols-outlined text-text-secondary text-[20px]">expand_more</span>
                                    </div>
                                </div>
                            </div>
                            <!-- Alert Level -->
                            <div class="md:col-span-1">
                                <label class="block text-text-secondary text-sm font-medium mb-2">Status Bahaya</label>
                                <div class="relative">
                                    <select
                                        class="w-full bg-background-dark border border-white/10 text-white text-sm rounded-lg focus:ring-primary focus:border-primary block p-2.5 h-11 appearance-none">
                                        <option>Semua Status</option>
                                        <option>Siaga 1 (Bahaya)</option>
                                        <option>Siaga 2 (Kritis)</option>
                                        <option>Siaga 3 (Waspada)</option>
                                        <option>Siaga 4 (Normal)</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <span
                                            class="material-symbols-outlined text-text-secondary text-[20px]">expand_more</span>
                                    </div>
                                </div>
                            </div>
                            <!-- Apply Button -->
                            <div class="md:col-span-1">
                                <button
                                    class="w-full bg-primary/10 border border-primary/20 text-primary hover:bg-primary hover:text-white font-medium rounded-lg text-sm px-5 py-2.5 text-center transition-all h-11 flex justify-center items-center gap-2">
                                    <span class="material-symbols-outlined text-[20px]">search</span>
                                    Terapkan Filter
                                </button>
                            </div>
                        </div>
                    </section>
                    <!-- Stats Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div
                            class="bg-surface-dark p-5 rounded-xl border border-white/5 relative overflow-hidden group">
                            <div
                                class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                                <span class="material-symbols-outlined text-6xl text-blue-500">water_drop</span>
                            </div>
                            <p class="text-text-secondary text-sm font-medium mb-1">
                                Total Laporan Banjir
                            </p>
                            <div class="flex items-baseline gap-2">
                                <h2 class="text-3xl font-bold text-white">124</h2>
                                <span
                                    class="text-emerald-500 text-xs font-medium flex items-center bg-emerald-500/10 px-1.5 py-0.5 rounded">
                                    <span class="material-symbols-outlined text-[14px] mr-0.5">trending_up</span>
                                    +12%
                                </span>
                            </div>
                            <div class="mt-4 h-1 w-full bg-background-dark rounded-full overflow-hidden">
                                <div class="h-full bg-blue-500 w-3/4 rounded-full"></div>
                            </div>
                        </div>
                        <div
                            class="bg-surface-dark p-5 rounded-xl border border-white/5 relative overflow-hidden group">
                            <div
                                class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                                <span class="material-symbols-outlined text-6xl text-red-500">warning</span>
                            </div>
                            <p class="text-text-secondary text-sm font-medium mb-1">
                                Siaga 1 (Kritis)
                            </p>
                            <div class="flex items-baseline gap-2">
                                <h2 class="text-3xl font-bold text-white">8</h2>
                                <span
                                    class="text-red-500 text-xs font-medium flex items-center bg-red-500/10 px-1.5 py-0.5 rounded">
                                    <span class="material-symbols-outlined text-[14px] mr-0.5">trending_up</span>
                                    +2
                                </span>
                            </div>
                            <div class="mt-4 h-1 w-full bg-background-dark rounded-full overflow-hidden">
                                <div class="h-full bg-red-500 w-1/4 rounded-full"></div>
                            </div>
                        </div>
                        <div
                            class="bg-surface-dark p-5 rounded-xl border border-white/5 relative overflow-hidden group">
                            <div
                                class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                                <span class="material-symbols-outlined text-6xl text-emerald-500">check_circle</span>
                            </div>
                            <p class="text-text-secondary text-sm font-medium mb-1">
                                Laporan Tertangani
                            </p>
                            <div class="flex items-baseline gap-2">
                                <h2 class="text-3xl font-bold text-white">98</h2>
                                <span
                                    class="text-emerald-500 text-xs font-medium flex items-center bg-emerald-500/10 px-1.5 py-0.5 rounded">
                                    92% Rate
                                </span>
                            </div>
                            <div class="mt-4 h-1 w-full bg-background-dark rounded-full overflow-hidden">
                                <div class="h-full bg-emerald-500 w-[92%] rounded-full"></div>
                            </div>
                        </div>
                    </div>
                    <!-- Charts Area -->
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <!-- Main Chart -->
                        <div class="lg:col-span-2 bg-surface-dark p-6 rounded-xl border border-white/5 shadow-lg">
                            <div class="flex justify-between items-center mb-6">
                                <h3 class="text-white font-semibold">
                                    Statistik Ketinggian Air Rata-rata
                                </h3>
                                <div class="flex gap-2">
                                    <span class="size-3 rounded-full bg-primary inline-block"></span>
                                    <span class="text-xs text-text-secondary">Pintu Air Manggarai</span>
                                    <span class="size-3 rounded-full bg-emerald-500 inline-block ml-2"></span>
                                    <span class="text-xs text-text-secondary">Katulampa</span>
                                </div>
                            </div>
                            <!-- Mock Chart Visual -->
                            <div
                                class="relative h-64 w-full flex items-end justify-between px-2 gap-2 border-b border-white/5 pb-2">
                                <!-- Bars for visual representation -->
                                <div class="w-full h-[30%] bg-primary/20 rounded-t-sm relative group">
                                    <div
                                        class="absolute bottom-0 w-full bg-primary/80 h-full rounded-t-sm transition-all duration-500 group-hover:bg-primary">
                                    </div>
                                </div>
                                <div class="w-full h-[45%] bg-primary/20 rounded-t-sm relative group">
                                    <div
                                        class="absolute bottom-0 w-full bg-primary/80 h-full rounded-t-sm transition-all duration-500 group-hover:bg-primary">
                                    </div>
                                </div>
                                <div class="w-full h-[60%] bg-primary/20 rounded-t-sm relative group">
                                    <div
                                        class="absolute bottom-0 w-full bg-primary/80 h-full rounded-t-sm transition-all duration-500 group-hover:bg-primary">
                                    </div>
                                </div>
                                <div class="w-full h-[85%] bg-primary/20 rounded-t-sm relative group">
                                    <div
                                        class="absolute bottom-0 w-full bg-primary/80 h-full rounded-t-sm transition-all duration-500 group-hover:bg-primary">
                                    </div>
                                </div>
                                <div class="w-full h-[70%] bg-primary/20 rounded-t-sm relative group">
                                    <div
                                        class="absolute bottom-0 w-full bg-primary/80 h-full rounded-t-sm transition-all duration-500 group-hover:bg-primary">
                                    </div>
                                </div>
                                <div class="w-full h-[50%] bg-primary/20 rounded-t-sm relative group">
                                    <div
                                        class="absolute bottom-0 w-full bg-primary/80 h-full rounded-t-sm transition-all duration-500 group-hover:bg-primary">
                                    </div>
                                </div>
                                <div class="w-full h-[65%] bg-primary/20 rounded-t-sm relative group">
                                    <div
                                        class="absolute bottom-0 w-full bg-primary/80 h-full rounded-t-sm transition-all duration-500 group-hover:bg-primary">
                                    </div>
                                </div>
                                <div class="w-full h-[40%] bg-primary/20 rounded-t-sm relative group">
                                    <div
                                        class="absolute bottom-0 w-full bg-primary/80 h-full rounded-t-sm transition-all duration-500 group-hover:bg-primary">
                                    </div>
                                </div>
                                <!-- Horizontal Grid Lines -->
                                <div class="absolute inset-0 flex flex-col justify-between pointer-events-none">
                                    <div class="w-full border-t border-dashed border-white/5 h-0"></div>
                                    <div class="w-full border-t border-dashed border-white/5 h-0"></div>
                                    <div class="w-full border-t border-dashed border-white/5 h-0"></div>
                                    <div class="w-full border-t border-dashed border-white/5 h-0"></div>
                                </div>
                            </div>
                            <div class="flex justify-between mt-2 text-xs text-text-secondary">
                                <span>1 Jan</span>
                                <span>5 Jan</span>
                                <span>10 Jan</span>
                                <span>15 Jan</span>
                                <span>20 Jan</span>
                                <span>25 Jan</span>
                                <span>30 Jan</span>
                            </div>
                        </div>
                        <!-- Secondary Chart -->
                        <div class="bg-surface-dark p-6 rounded-xl border border-white/5 shadow-lg flex flex-col">
                            <h3 class="text-white font-semibold mb-6">
                                Distribusi Wilayah
                            </h3>
                            <div class="flex-1 flex items-center justify-center relative">
                                <!-- Donut Chart Representation -->
                                <div
                                    class="size-48 rounded-full border-[16px] border-primary/20 border-t-primary border-r-emerald-500 border-l-orange-400 rotate-45 relative flex items-center justify-center">
                                    <div class="text-center">
                                        <p class="text-2xl font-bold text-white">4 Wilayah</p>
                                        <p class="text-xs text-text-secondary">Terdampak</p>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-6 space-y-3">
                                <div class="flex justify-between items-center text-sm">
                                    <div class="flex items-center gap-2">
                                        <span class="size-2 rounded-full bg-primary"></span>
                                        <span class="text-text-secondary">Jakarta Selatan</span>
                                    </div>
                                    <span class="text-white font-medium">45%</span>
                                </div>
                                <div class="flex justify-between items-center text-sm">
                                    <div class="flex items-center gap-2">
                                        <span class="size-2 rounded-full bg-emerald-500"></span>
                                        <span class="text-text-secondary">Jakarta Timur</span>
                                    </div>
                                    <span class="text-white font-medium">30%</span>
                                </div>
                                <div class="flex justify-between items-center text-sm">
                                    <div class="flex items-center gap-2">
                                        <span class="size-2 rounded-full bg-orange-400"></span>
                                        <span class="text-text-secondary">Bogor</span>
                                    </div>
                                    <span class="text-white font-medium">25%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Data Table -->
                    <div class="bg-surface-dark rounded-xl border border-white/5 shadow-lg overflow-hidden">
                        <div
                            class="p-6 border-b border-white/5 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            <h3 class="text-white font-semibold text-lg">
                                Rincian Laporan Masuk
                            </h3>
                            <div class="relative w-full sm:w-64">
                                <input
                                    class="w-full bg-background-dark border border-white/10 text-white text-sm rounded-lg focus:ring-primary focus:border-primary block p-2 pl-9"
                                    placeholder="Cari ID Laporan atau Lokasi..." type="text" />
                                <div class="absolute inset-y-0 left-0 pl-2.5 flex items-center pointer-events-none">
                                    <span
                                        class="material-symbols-outlined text-text-secondary text-[18px]">search</span>
                                </div>
                            </div>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left text-text-secondary">
                                <thead class="text-xs text-text-secondary uppercase bg-white/5">
                                    <tr>
                                        <th class="px-6 py-4 font-medium" scope="col">
                                            ID Laporan
                                        </th>
                                        <th class="px-6 py-4 font-medium" scope="col">Waktu</th>
                                        <th class="px-6 py-4 font-medium" scope="col">
                                            Lokasi Pos
                                        </th>
                                        <th class="px-6 py-4 font-medium" scope="col">
                                            Tinggi Air
                                        </th>
                                        <th class="px-6 py-4 font-medium" scope="col">Status</th>
                                        <th class="px-6 py-4 font-medium" scope="col">Petugas</th>
                                        <th class="px-6 py-4 font-medium text-right" scope="col">
                                            Aksi
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-white/5">
                                    <tr class="bg-surface-dark hover:bg-white/5 transition-colors">
                                        <td class="px-6 py-4 font-medium text-white">
                                            #LPT-2023-089
                                        </td>
                                        <td class="px-6 py-4">24 Okt, 14:30</td>
                                        <td class="px-6 py-4 text-white">Pintu Air Manggarai</td>
                                        <td class="px-6 py-4 text-white font-bold">960 cm</td>
                                        <td class="px-6 py-4">
                                            <span
                                                class="bg-red-500/10 text-red-400 text-xs font-medium px-2.5 py-0.5 rounded border border-red-500/20">Siaga
                                                1</span>
                                        </td>
                                        <td class="px-6 py-4 flex items-center gap-2">
                                            <div class="size-6 rounded-full bg-white/10 overflow-hidden bg-cover bg-center"
                                                data-alt="Avatar of Budi Santoso"
                                                style="
                            background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuC95bGi2ek5i1fa_sSIZhvtweQyU4U-mG5vndKKXRuZdRQgosgM0BJs0pQZ9hovQTyWHam8eUGPBICGQ-ZzamPi3YEzLDAzdJLDa6qk_TYslF6jMY6rJ1yazmVeBBpc-7pCJpD4S9mjgVfnWpBG1EsOXEH3nG04S1IGy_oqBaJ6WuEZ6NrwfkDM_Y2b1RlcJ2TKww4yO74vZbg7WX9GwP471vfMJtgdOHfutb7MFHxVO_jyQc7v0kBEMMwMoQDB9-YrsPV3DdjYxUrs');
                          ">
                                            </div>
                                            <span>Budi Santoso</span>
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <button
                                                class="text-primary hover:text-white transition-colors text-sm font-medium">
                                                Detail
                                            </button>
                                        </td>
                                    </tr>
                                    <tr class="bg-surface-dark hover:bg-white/5 transition-colors">
                                        <td class="px-6 py-4 font-medium text-white">
                                            #LPT-2023-088
                                        </td>
                                        <td class="px-6 py-4">24 Okt, 13:15</td>
                                        <td class="px-6 py-4 text-white">Bendung Katulampa</td>
                                        <td class="px-6 py-4 text-white font-bold">120 cm</td>
                                        <td class="px-6 py-4">
                                            <span
                                                class="bg-orange-500/10 text-orange-400 text-xs font-medium px-2.5 py-0.5 rounded border border-orange-500/20">Siaga
                                                3</span>
                                        </td>
                                        <td class="px-6 py-4 flex items-center gap-2">
                                            <div class="size-6 rounded-full bg-white/10 overflow-hidden bg-cover bg-center"
                                                data-alt="Avatar of Siti Aminah"
                                                style="
                            background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuCuU63Kvwtd8YygTpbQO90Rh9bvaE0bcRnszRKXad7gX1xONUXJTmbAIWXkgL7KhK16YdaMFnJ3eBpL9tgL1xdAZlDhzOaLPO1fzmSjI-Yf7ajOdpxeybmBr_7oi1kuNgWBt8GRQf1r5PkTEg0wDziDZu4MTsx8vSp1U4FtO2JptrTZN5zxh_fbJUXpo5J44zIQSw5oruU7Ex-tt_obvvyQwAxAySuK64i2W5u4xdl1aUCV21icxI6glEKT11QLlQ6uRierMQui8Pnr');
                          ">
                                            </div>
                                            <span>Siti Aminah</span>
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <button
                                                class="text-primary hover:text-white transition-colors text-sm font-medium">
                                                Detail
                                            </button>
                                        </td>
                                    </tr>
                                    <tr class="bg-surface-dark hover:bg-white/5 transition-colors">
                                        <td class="px-6 py-4 font-medium text-white">
                                            #LPT-2023-087
                                        </td>
                                        <td class="px-6 py-4">24 Okt, 11:00</td>
                                        <td class="px-6 py-4 text-white">Pos Depok</td>
                                        <td class="px-6 py-4 text-white font-bold">150 cm</td>
                                        <td class="px-6 py-4">
                                            <span
                                                class="bg-emerald-500/10 text-emerald-400 text-xs font-medium px-2.5 py-0.5 rounded border border-emerald-500/20">Siaga
                                                4</span>
                                        </td>
                                        <td class="px-6 py-4 flex items-center gap-2">
                                            <div class="size-6 rounded-full bg-white/10 overflow-hidden bg-cover bg-center"
                                                data-alt="Avatar of Rudi Hartono"
                                                style="
                            background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuCKeqjICG3EGAYPIF8qHRNNSlW6-T9s7SlA-Caq9JApHJhlGi8aD4VcN43SuKOOxC_9GVMm-cIwSPNycGivunjGsf8Au8gV5mxq2TqfmmIwpz2PwIUWswjseALiWLtHk9mTmRXle-tniZf_kPUj6LB23l32dKju1nX2QGeqaZBtjMGf7w3b6FzuAwL7R2YBro9r_H1WxwBIok1YxFmbb2ZWCt9GX-7jY-S0g1NEWBKIWnlGkd8JGCXgCXS4v0-9Ov0BLChISnOSynFQ');
                          ">
                                            </div>
                                            <span>Rudi Hartono</span>
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <button
                                                class="text-primary hover:text-white transition-colors text-sm font-medium">
                                                Detail
                                            </button>
                                        </td>
                                    </tr>
                                    <tr class="bg-surface-dark hover:bg-white/5 transition-colors">
                                        <td class="px-6 py-4 font-medium text-white">
                                            #LPT-2023-086
                                        </td>
                                        <td class="px-6 py-4">23 Okt, 22:45</td>
                                        <td class="px-6 py-4 text-white">Pintu Air Karet</td>
                                        <td class="px-6 py-4 text-white font-bold">460 cm</td>
                                        <td class="px-6 py-4">
                                            <span
                                                class="bg-yellow-500/10 text-yellow-400 text-xs font-medium px-2.5 py-0.5 rounded border border-yellow-500/20">Siaga
                                                2</span>
                                        </td>
                                        <td class="px-6 py-4 flex items-center gap-2">
                                            <div class="size-6 rounded-full bg-white/10 overflow-hidden bg-cover bg-center"
                                                data-alt="Avatar of Ahmad Dani"
                                                style="
                            background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuCzQXs2p8MV1BKsI4T4x_moUDZm30tnWtaJpHdf7CV0YY_eq8vxAXFxPMjLLM4ZL2Ra1KSY3y21HwL6aog5_E3cWx6RIR0tGlIaVFp1uR6m2IB_3tQe5mqMYMFyDjz6FX2pxQE0MKlKPRcU7_DjLPAGam9OKsMQSGjKNxB62ntVoO7eZ4ePB1kxNW3slxXdylRzeCWlRIGr5iildTqU9ph5aU1D2Pz-nMaiYg0WqozlA_LB1fawluIJ3XRluSq2IbvqXayTHeaWyCCu');
                          ">
                                            </div>
                                            <span>Ahmad Dani</span>
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <button
                                                class="text-primary hover:text-white transition-colors text-sm font-medium">
                                                Detail
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="p-4 border-t border-white/5 flex items-center justify-between">
                            <span class="text-sm text-text-secondary">Menampilkan 1-4 dari 124 laporan</span>
                            <div class="flex gap-2">
                                <button
                                    class="px-3 py-1 text-sm rounded border border-white/10 text-text-secondary hover:text-white hover:bg-white/5 disabled:opacity-50">
                                    Previous
                                </button>
                                <button
                                    class="px-3 py-1 text-sm rounded border border-white/10 text-white bg-white/10">
                                    1
                                </button>
                                <button
                                    class="px-3 py-1 text-sm rounded border border-white/10 text-text-secondary hover:text-white hover:bg-white/5">
                                    2
                                </button>
                                <button
                                    class="px-3 py-1 text-sm rounded border border-white/10 text-text-secondary hover:text-white hover:bg-white/5">
                                    3
                                </button>
                                <button
                                    class="px-3 py-1 text-sm rounded border border-white/10 text-text-secondary hover:text-white hover:bg-white/5">
                                    Next
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>

</html>
