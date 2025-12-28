<!DOCTYPE html>

<html class="dark" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Monitoring Laporan Masyarakat - FloodMonitor</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@400;500;700;900&amp;display=swap"
        rel="stylesheet" />
    <!-- Material Symbols -->
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        primary: "#0d33f2",
                        "background-light": "#f5f6f8",
                        "background-dark": "#101322",
                        "surface-dark": "#1e2235",
                        "border-dark": "#2d334e",
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
        /* Custom scrollbar for dark mode */
        .dark ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        .dark ::-webkit-scrollbar-track {
            background: #101322;
        }

        .dark ::-webkit-scrollbar-thumb {
            background: #2d334e;
            border-radius: 4px;
        }

        .dark ::-webkit-scrollbar-thumb:hover {
            background: #3e4566;
        }

        .material-symbols-outlined {
            font-size: 20px;
        }
    </style>
</head>

<body
    class="bg-background-light dark:bg-background-dark font-display text-gray-900 dark:text-white h-screen overflow-hidden flex">
    <!-- Sidebar -->
    <aside
        class="w-64 flex-shrink-0 border-r border-gray-200 dark:border-border-dark bg-white dark:bg-[#101323] flex flex-col justify-between hidden md:flex">
        <div class="flex flex-col h-full">
            <!-- Logo Area -->
            <div class="p-6 flex items-center gap-3">
                <div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-10"
                    data-alt="Blue wave gradient logo"
                    style="
                            background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuDiObSpEJBlYfXIDEOvpaQdVG2huCUyODpGILLEaUHD76L74IsafFArxKQksuekuR_MDHoITckqtMh_YjGIY827tdb3YBj1eiZmg5iT_biOKserH5O-X6B1iw2NQa_5wiJwXaqGQ4LSSaCfUQOnOV8-w3hlPmAo-PmnhkezIhkX90dDUdvO5k8eiae7xjpv9XxVKYGC8tg2ZxVQEqWA9_RGuGqyGTIdwzQteDAXPQ03Q0i-Mw2zSlLDAt8yftSjXMqib6nFZZuqqz_o');
                        ">
                </div>
                <div class="flex flex-col">
                    <h1 class="text-gray-900 dark:text-white text-base font-bold leading-normal">
                        FloodMonitor
                    </h1>
                    <p class="text-gray-500 dark:text-[#909acb] text-xs font-normal leading-normal">
                        Admin Panel
                    </p>
                </div>
            </div>
            <!-- Navigation -->
            <nav class="flex flex-col gap-2 px-4 py-2 flex-1 overflow-y-auto">
                <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-500 dark:text-[#909acb] hover:bg-gray-100 dark:hover:bg-surface-dark transition-colors"
                    href="#">
                    <span class="material-symbols-outlined">dashboard</span>
                    <span class="text-sm font-medium">Dashboard</span>
                </a>
                <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-500 dark:text-[#909acb] hover:bg-gray-100 dark:hover:bg-surface-dark transition-colors"
                    href="#">
                    <span class="material-symbols-outlined">water_lux</span>
                    <span class="text-sm font-medium">Manajemen Pos Pantau</span>
                </a>
                <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-500 dark:text-[#909acb] hover:bg-gray-100 dark:hover:bg-surface-dark transition-colors"
                    href="#">
                    <span class="material-symbols-outlined">groups</span>
                    <span class="text-sm font-medium">Manajemen Petugas</span>
                </a>
                <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-500 dark:text-[#909acb] hover:bg-gray-100 dark:hover:bg-surface-dark transition-colors"
                    href="#">
                    <span class="material-symbols-outlined">assignment_ind</span>
                    <span class="text-sm font-medium">Laporan Petugas</span>
                </a>
                <!-- Active State -->
                <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg bg-primary text-white shadow-md"
                    href="#">
                    <span class="material-symbols-outlined">campaign</span>
                    <span class="text-sm font-medium">Laporan Masyarakat</span>
                </a>
                <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-500 dark:text-[#909acb] hover:bg-gray-100 dark:hover:bg-surface-dark transition-colors"
                    href="#">
                    <span class="material-symbols-outlined">water</span>
                    <span class="text-sm font-medium">Potensi Banjir</span>
                </a>
                <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-500 dark:text-[#909acb] hover:bg-gray-100 dark:hover:bg-surface-dark transition-colors"
                    href="#">
                    <span class="material-symbols-outlined">summarize</span>
                    <span class="text-sm font-medium">Rekap Laporan</span>
                </a>
            </nav>
            <!-- Bottom Action -->
            <div class="p-4 border-t border-gray-200 dark:border-border-dark">
                <button
                    class="flex items-center gap-3 w-full px-3 py-2 text-red-500 hover:bg-red-500/10 rounded-lg transition-colors">
                    <span class="material-symbols-outlined">logout</span>
                    <span class="text-sm font-medium">Log Out</span>
                </button>
            </div>
        </div>
    </aside>
    <!-- Main Content -->
    <main class="flex-1 flex flex-col h-full bg-background-light dark:bg-background-dark overflow-hidden relative">
        <!-- Top Navbar -->
        <header
            class="flex items-center justify-between whitespace-nowrap border-b border-solid border-gray-200 dark:border-border-dark px-8 py-4 bg-white dark:bg-[#101323] z-10 shrink-0">
            <div class="flex items-center gap-4 text-gray-900 dark:text-white">
                <button class="md:hidden p-1 rounded-md hover:bg-gray-100 dark:hover:bg-surface-dark">
                    <span class="material-symbols-outlined">menu</span>
                </button>
                <h2 class="text-lg font-bold leading-tight tracking-tight">
                    Laporan Masyarakat
                </h2>
            </div>
            <div class="flex flex-1 justify-end gap-6 items-center">
                <button
                    class="flex items-center justify-center rounded-full w-10 h-10 hover:bg-gray-100 dark:hover:bg-surface-dark text-gray-500 dark:text-white transition-colors relative">
                    <span class="material-symbols-outlined">notifications</span>
                    <span
                        class="absolute top-2 right-2 w-2 h-2 bg-red-500 rounded-full border border-white dark:border-[#101323]"></span>
                </button>
                <div class="flex items-center gap-3 pl-6 border-l border-gray-200 dark:border-border-dark">
                    <div class="text-right hidden sm:block">
                        <p class="text-sm font-bold text-gray-900 dark:text-white">
                            Admin Utama
                        </p>
                        <p class="text-xs text-gray-500 dark:text-[#909acb]">
                            admin@floodmonitor.id
                        </p>
                    </div>
                    <div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-10 ring-2 ring-gray-200 dark:ring-border-dark"
                        data-alt="Portrait of admin user"
                        style="
                                background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuCatej-2RiAzNKXI9PKWV1AETF33gGatEJP55rtOTyd8D5bRtYNTR_5srsumYIbak6zc0AOvB9GlJL7HE3Dswpq2tjKE7_TzPiaXIRPUyxwWLoTy9g-H_YqCKet41LySyjjB16WnN1-sNQhmxwGITUF17xdyV22II1kr8yP5I7VVzoBIDqY3erPZiLTqUbI8XuczGT-VSLo5XWGuzTzlNemlpJpAU9g17_sjt6UQAwnm-84vFHsGTjivND6NNrEnHCQJU6gPgDgZFVq');
                            ">
                    </div>
                </div>
            </div>
        </header>
        <!-- Scrollable Page Content -->
        <div class="flex-1 overflow-y-auto p-4 md:p-8 scroll-smooth">
            <div class="max-w-[1200px] mx-auto flex flex-col gap-6">
                <!-- Page Heading -->
                <div class="flex flex-col md:flex-row justify-between gap-4 items-start md:items-center">
                    <div class="flex flex-col gap-1">
                        <h1 class="text-gray-900 dark:text-white text-3xl font-black leading-tight tracking-tight">
                            Monitoring Laporan Masyarakat
                        </h1>
                        <p class="text-gray-500 dark:text-[#909acb] text-base font-normal">
                            Pantau dan kelola laporan banjir yang masuk dari
                            warga secara real-time
                        </p>
                    </div>
                    <button
                        class="flex items-center justify-center gap-2 rounded-lg h-10 px-4 bg-primary hover:bg-primary/90 text-white text-sm font-bold shadow-lg shadow-primary/20 transition-all">
                        <span class="material-symbols-outlined text-[18px]">download</span>
                        <span>Unduh Laporan</span>
                    </button>
                </div>
                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div
                        class="flex flex-col gap-2 rounded-xl p-6 border border-gray-200 dark:border-border-dark bg-white dark:bg-surface-dark shadow-sm">
                        <div class="flex justify-between items-start">
                            <p class="text-gray-500 dark:text-[#909acb] text-sm font-medium">
                                Total Laporan Masuk
                            </p>
                            <span
                                class="material-symbols-outlined text-primary bg-primary/10 p-1.5 rounded-lg">inbox</span>
                        </div>
                        <div class="flex items-baseline gap-2 mt-2">
                            <p class="text-gray-900 dark:text-white text-3xl font-bold">
                                1,245
                            </p>
                            <p class="text-emerald-500 text-sm font-medium flex items-center gap-0.5">
                                <span class="material-symbols-outlined text-sm">trending_up</span>
                                +12%
                            </p>
                        </div>
                    </div>
                    <div
                        class="flex flex-col gap-2 rounded-xl p-6 border border-gray-200 dark:border-border-dark bg-white dark:bg-surface-dark shadow-sm relative overflow-hidden">
                        <div class="absolute right-0 top-0 h-full w-1 bg-red-500"></div>
                        <div class="flex justify-between items-start">
                            <p class="text-gray-500 dark:text-[#909acb] text-sm font-medium">
                                Belum Ditangani
                            </p>
                            <span
                                class="material-symbols-outlined text-red-500 bg-red-500/10 p-1.5 rounded-lg">warning</span>
                        </div>
                        <div class="flex items-baseline gap-2 mt-2">
                            <p class="text-gray-900 dark:text-white text-3xl font-bold">
                                24
                            </p>
                            <p class="text-red-500 text-sm font-medium flex items-center gap-0.5">
                                <span class="material-symbols-outlined text-sm">priority_high</span>
                                Urgent
                            </p>
                        </div>
                    </div>
                    <div
                        class="flex flex-col gap-2 rounded-xl p-6 border border-gray-200 dark:border-border-dark bg-white dark:bg-surface-dark shadow-sm">
                        <div class="flex justify-between items-start">
                            <p class="text-gray-500 dark:text-[#909acb] text-sm font-medium">
                                Sedang Diproses
                            </p>
                            <span
                                class="material-symbols-outlined text-amber-500 bg-amber-500/10 p-1.5 rounded-lg">engineering</span>
                        </div>
                        <div class="flex items-baseline gap-2 mt-2">
                            <p class="text-gray-900 dark:text-white text-3xl font-bold">
                                15
                            </p>
                            <p class="text-gray-500 dark:text-[#909acb] text-sm font-medium">
                                Tim Lapangan Aktif
                            </p>
                        </div>
                    </div>
                </div>
                <!-- Filters & Search Toolbar -->
                <div
                    class="flex flex-col md:flex-row gap-4 items-center justify-between bg-white dark:bg-surface-dark p-4 rounded-xl border border-gray-200 dark:border-border-dark shadow-sm">
                    <label
                        class="flex items-center w-full md:w-96 bg-gray-50 dark:bg-[#101323] rounded-lg border border-gray-200 dark:border-border-dark px-3 py-2.5 focus-within:ring-2 focus-within:ring-primary transition-all">
                        <span class="material-symbols-outlined text-gray-400">search</span>
                        <input
                            class="bg-transparent border-none text-sm w-full text-gray-900 dark:text-white placeholder:text-gray-400 focus:ring-0"
                            placeholder="Cari nama pelapor, lokasi..." type="text" />
                    </label>
                    <div class="flex gap-3 w-full md:w-auto overflow-x-auto pb-1 md:pb-0">
                        <button
                            class="flex items-center gap-2 px-4 py-2 bg-gray-50 dark:bg-[#101323] border border-gray-200 dark:border-border-dark rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-border-dark transition-colors whitespace-nowrap">
                            <span class="material-symbols-outlined text-[18px]">filter_list</span>
                            Filter
                        </button>
                        <button
                            class="flex items-center gap-2 px-4 py-2 bg-gray-50 dark:bg-[#101323] border border-gray-200 dark:border-border-dark rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-border-dark transition-colors whitespace-nowrap">
                            <span class="material-symbols-outlined text-[18px]">calendar_today</span>
                            Tanggal
                        </button>
                    </div>
                </div>
                <!-- Reports Table -->
                <div
                    class="rounded-xl border border-gray-200 dark:border-border-dark bg-white dark:bg-surface-dark shadow-sm overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr
                                    class="bg-gray-50 dark:bg-[#151928] border-b border-gray-200 dark:border-border-dark">
                                    <th
                                        class="p-4 text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-[#909acb]">
                                        Waktu
                                    </th>
                                    <th
                                        class="p-4 text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-[#909acb]">
                                        Pelapor
                                    </th>
                                    <th
                                        class="p-4 text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-[#909acb]">
                                        Lokasi &amp; Foto
                                    </th>
                                    <th
                                        class="p-4 text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-[#909acb]">
                                        Deskripsi
                                    </th>
                                    <th
                                        class="p-4 text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-[#909acb]">
                                        Status
                                    </th>
                                    <th
                                        class="p-4 text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-[#909acb] text-right">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-border-dark">
                                <!-- Row 1: Urgent -->
                                <tr class="hover:bg-gray-50 dark:hover:bg-[#252a40] transition-colors group">
                                    <td class="p-4 align-top whitespace-nowrap">
                                        <div class="flex flex-col">
                                            <span class="text-sm font-medium text-gray-900 dark:text-white">10:42
                                                AM</span>
                                            <span class="text-xs text-gray-500">Hari ini</span>
                                        </div>
                                    </td>
                                    <td class="p-4 align-top">
                                        <div class="flex items-center gap-3">
                                            <div class="bg-cover bg-center size-8 rounded-full"
                                                data-alt="Avatar of Budi Santoso"
                                                style="
                                                        background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuDK82Y6SR9nCuKIdaYFPKKfa3pvPS8UgxTvdjZ7WEwoHwkq7EysoVRGmsAlFPLJC4piVAmH81CyoC_ubbO-ZM2sIpQNMBbM2mw4HZSFyMRm_jQOG1mSM7iK5b2cZ3v3kSYJgt2_djO3nE1qOOvzdHTUryyAzodtfmnjzOEKrn6G9xX3imDbPc_09Jsw47YszYp9fj27-bgmpOi_W9nuUDQ_Zq-a448JLkCnCLi2T1GxoKJmC31Sb7d6jqa9EBFFILFtf0LRR4IcHKZg');
                                                    ">
                                            </div>
                                            <div class="flex flex-col">
                                                <span class="text-sm font-bold text-gray-900 dark:text-white">Budi
                                                    Santoso</span>
                                                <span class="text-xs text-gray-500">+62 812-3456-7890</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-4 align-top">
                                        <div class="flex flex-col gap-2">
                                            <div
                                                class="flex items-center gap-1.5 text-sm text-gray-900 dark:text-white">
                                                <span
                                                    class="material-symbols-outlined text-primary text-[16px]">location_on</span>
                                                Jl. Melati No. 4, Baleendah
                                            </div>
                                            <div class="h-20 w-32 rounded-lg bg-cover bg-center cursor-pointer hover:opacity-80 transition-opacity"
                                                data-alt="Flooded residential street"
                                                style="
                                                        background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuD8kBTnBHl0XPDHRSMKi14z3PjM-HSkjOKGW_RwroZ8NjNN23fDuvXPwoKTLwuIVaR57rHdQvc3glYjNLpMCDtprBRgsk4NxqyPbg5PIqx3MmoIaEBC5RHzGeqkZCIL4oGa7zT_vGFB0IAy6PapXloHFSWYl3zoSRKgTRE8fdOfNsIbLZ-CxN7x8xe74TTU9PU7usSQhSIpbar0dSutDeckQ4l6WbJhS6RKtCOjkEyeJWuGZNAlCsqHoHnEAH5XtthQLwQWgQVIyZ9_');
                                                    ">
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-4 align-top max-w-[250px]">
                                        <p class="text-sm text-gray-600 dark:text-gray-300 line-clamp-2">
                                            Air sudah masuk setinggi lutut
                                            orang dewasa di dalam rumah.
                                            Arus cukup deras di jalan utama.
                                            Mohon bantuan evakuasi lansia.
                                        </p>
                                    </td>
                                    <td class="p-4 align-top">
                                        <span
                                            class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700 dark:bg-red-500/20 dark:text-red-400 border border-red-200 dark:border-red-500/30">
                                            <span class="size-1.5 rounded-full bg-red-500 animate-pulse"></span>
                                            Menunggu
                                        </span>
                                    </td>
                                    <td class="p-4 align-top text-right">
                                        <button
                                            class="inline-flex items-center justify-center h-8 px-3 rounded-md bg-primary hover:bg-primary/90 text-white text-xs font-bold transition-colors">
                                            Tindak Lanjuti
                                        </button>
                                    </td>
                                </tr>
                                <!-- Row 2: In Progress -->
                                <tr class="hover:bg-gray-50 dark:hover:bg-[#252a40] transition-colors group">
                                    <td class="p-4 align-top whitespace-nowrap">
                                        <div class="flex flex-col">
                                            <span class="text-sm font-medium text-gray-900 dark:text-white">09:15
                                                AM</span>
                                            <span class="text-xs text-gray-500">Hari ini</span>
                                        </div>
                                    </td>
                                    <td class="p-4 align-top">
                                        <div class="flex items-center gap-3">
                                            <div class="bg-cover bg-center size-8 rounded-full"
                                                data-alt="Avatar of Siti Aminah"
                                                style="
                                                        background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuAPZ7jTvB4ErxPtacFbwjy_cXyHSY3ywiupI6yMABR1-7gMnKwGyV9iRIC328-oSpshf1qRb1OwrNv63v3isAFmwhmjlibDGvm6o8DQr_OQKZRTD4nRDcjcuL0j4LLyTQACo7u4VkgmlVmPUff5iZgq_d5EvbVlPOQfI0DywBh_dCpepY_4pLPIrXVU6IODhxXzsf1Qp2I-aqKXy6CxNzMEFImYtTm-UOrUHREp6U0DCts-U5a6fdRLxjy-dxeN4mNn4Da5y1o_4fue');
                                                    ">
                                            </div>
                                            <div class="flex flex-col">
                                                <span class="text-sm font-bold text-gray-900 dark:text-white">Siti
                                                    Aminah</span>
                                                <span class="text-xs text-gray-500">+62 813-9988-7766</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-4 align-top">
                                        <div class="flex flex-col gap-2">
                                            <div
                                                class="flex items-center gap-1.5 text-sm text-gray-900 dark:text-white">
                                                <span
                                                    class="material-symbols-outlined text-gray-400 text-[16px]">location_on</span>
                                                Komp. Cingised Blok C
                                            </div>
                                            <div class="h-20 w-32 rounded-lg bg-cover bg-center cursor-pointer hover:opacity-80 transition-opacity"
                                                data-alt="Clogged drainage system"
                                                style="
                                                        background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuCENtG-rw1vGSvDxp_QS6MdNa5k88jIdRcbC84JLzGCotWzqLI3f6_trdQ8FY6K-ulBcA_gMgs_kFeXVVr6wUf9_31j3n-d2j1G2AaDpboHh09M5_A_qdv2NOFAHmhMciC5t5GFoJZOZNd8wGUGc9Ai2sHoT35V8BdAUHlz-PhJ1A8ny_VN2Q9M3sWtjHyOb4jR0mJ_4X2h_UiY_Gvr4OjBKQtHWj_JC1wKVdD3CUKGZNK-zbzVcSeJWGZoGkpohyz18t-G6kTgTVKO');
                                                    ">
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-4 align-top max-w-[250px]">
                                        <p class="text-sm text-gray-600 dark:text-gray-300 line-clamp-2">
                                            Saluran drainase tersumbat
                                            sampah plastik menyebabkan
                                            genangan setinggi 30cm.
                                        </p>
                                    </td>
                                    <td class="p-4 align-top">
                                        <span
                                            class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-700 dark:bg-amber-500/20 dark:text-amber-400 border border-amber-200 dark:border-amber-500/30">
                                            Diproses
                                        </span>
                                    </td>
                                    <td class="p-4 align-top text-right">
                                        <button
                                            class="inline-flex items-center justify-center h-8 px-3 rounded-md border border-gray-300 dark:border-border-dark hover:bg-gray-100 dark:hover:bg-surface-dark/50 text-gray-700 dark:text-white text-xs font-bold transition-colors">
                                            Detail
                                        </button>
                                    </td>
                                </tr>
                                <!-- Row 3: Resolved -->
                                <tr class="hover:bg-gray-50 dark:hover:bg-[#252a40] transition-colors group">
                                    <td class="p-4 align-top whitespace-nowrap">
                                        <div class="flex flex-col">
                                            <span
                                                class="text-sm font-medium text-gray-900 dark:text-white">Yesterday</span>
                                            <span class="text-xs text-gray-500">4:30 PM</span>
                                        </div>
                                    </td>
                                    <td class="p-4 align-top">
                                        <div class="flex items-center gap-3">
                                            <div class="bg-cover bg-center size-8 rounded-full"
                                                data-alt="Avatar of Ahmad Dani"
                                                style="
                                                        background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuBodEEJqyWOkH7iOnW0xJqegVTOQ1T-RsetGxG-FAZ_d62b7x2g9Iuq7xvByiWpI_kggbtiiqHMjIx7bnlzmU0eHncGBIPUF_ismBD9zXLEQWZaVyvLsjRiBH1fqGDaUsyjyln_f1FboZxYc5cHzatvgfyobO018WMVWByMgqRuaBDTK0umlriAq5huQOvBNDV1QzHgrG0r4srgGjGMSEXowpIUrW64geB9YC1gvKOTzWYHNW_lQ37mXieYqJu0njCkBgc4wi_arupV');
                                                    ">
                                            </div>
                                            <div class="flex flex-col">
                                                <span class="text-sm font-bold text-gray-900 dark:text-white">Ahmad
                                                    Dani</span>
                                                <span class="text-xs text-gray-500">+62 857-1122-3344</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-4 align-top">
                                        <div class="flex flex-col gap-2">
                                            <div
                                                class="flex items-center gap-1.5 text-sm text-gray-900 dark:text-white">
                                                <span
                                                    class="material-symbols-outlined text-gray-400 text-[16px]">location_on</span>
                                                Jembatan Dayeuhkolot
                                            </div>
                                            <!-- No photo for this one to vary design -->
                                            <div class="flex items-center gap-2 text-xs text-gray-500">
                                                <span
                                                    class="material-symbols-outlined text-[14px]">image_not_supported</span>
                                                Tidak ada foto
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-4 align-top max-w-[250px]">
                                        <p class="text-sm text-gray-600 dark:text-gray-300 line-clamp-2">
                                            Laporan debit air sungai mulai
                                            naik, namun masih aman. Hanya
                                            untuk info pantauan.
                                        </p>
                                    </td>
                                    <td class="p-4 align-top">
                                        <span
                                            class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-500/30">
                                            Selesai
                                        </span>
                                    </td>
                                    <td class="p-4 align-top text-right">
                                        <button
                                            class="inline-flex items-center justify-center h-8 px-3 rounded-md border border-gray-300 dark:border-border-dark hover:bg-gray-100 dark:hover:bg-surface-dark/50 text-gray-700 dark:text-white text-xs font-bold transition-colors">
                                            Arsip
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- Pagination -->
                    <div
                        class="flex items-center justify-between p-4 border-t border-gray-200 dark:border-border-dark bg-gray-50 dark:bg-surface-dark">
                        <p class="text-sm text-gray-500 dark:text-[#909acb]">
                            Menampilkan 1-3 dari 1245 laporan
                        </p>
                        <div class="flex gap-2">
                            <button
                                class="p-1 rounded-md hover:bg-gray-200 dark:hover:bg-[#252a40] text-gray-500 dark:text-white disabled:opacity-50">
                                <span class="material-symbols-outlined">chevron_left</span>
                            </button>
                            <button class="px-3 py-1 rounded-md bg-primary text-white text-sm font-bold">
                                1
                            </button>
                            <button
                                class="px-3 py-1 rounded-md hover:bg-gray-200 dark:hover:bg-[#252a40] text-gray-700 dark:text-white text-sm font-medium">
                                2
                            </button>
                            <button
                                class="px-3 py-1 rounded-md hover:bg-gray-200 dark:hover:bg-[#252a40] text-gray-700 dark:text-white text-sm font-medium">
                                3
                            </button>
                            <span class="px-2 py-1 text-gray-500">...</span>
                            <button
                                class="p-1 rounded-md hover:bg-gray-200 dark:hover:bg-[#252a40] text-gray-500 dark:text-white">
                                <span class="material-symbols-outlined">chevron_right</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>

</html>
