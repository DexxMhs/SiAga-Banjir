@extends('admin.layouts.app')

@section('script')
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        primary: "#607afb",
                        "primary-dark": "#1634c0",
                        "background-light": "#f5f6f8",
                        "background-dark": "#0f1323",
                        "surface-dark": "#181d35",
                        "surface-dark-lighter": "#21284a",
                        success: "#0bda65",
                        warning: "#f59e0b",
                        danger: "#ef4444",
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
@endsection

@section('css')
    <style>
        /* Custom scrollbar for dark mode */
        .dark ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        .dark ::-webkit-scrollbar-track {
            background: #0f1323;
        }

        .dark ::-webkit-scrollbar-thumb {
            background: #21284a;
            border-radius: 4px;
        }

        .dark ::-webkit-scrollbar-thumb:hover {
            background: #374151;
        }
    </style>
@endsection

@section('content')

    <body class="bg-background-light dark:bg-background-dark text-slate-900 dark:text-white font-display overflow-hidden">
        <div class="flex h-screen w-full">
            @include('admin.includes.sidebar')
            <!-- Main Content -->
            <main class="flex-1 flex flex-col h-full overflow-hidden relative">
                <!-- Top Header -->
                @include('admin.includes.header')
                <!-- Scrollable Dashboard Area -->
                <div class="flex-1 overflow-y-auto p-4 md:p-8 scroll-smooth">
                    <div class="max-w-7xl mx-auto space-y-6">
                        <!-- Welcome & Summary -->
                        <div class="flex flex-col md:flex-row gap-6 items-stretch">
                            <!-- Welcome Banner -->
                            <div
                                class="flex-1 rounded-2xl overflow-hidden relative min-h-[160px] bg-gradient-to-r from-primary to-primary-dark shadow-lg">
                                <div
                                    class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-20">
                                </div>
                                <div class="relative z-10 p-6 md:p-8 flex flex-col justify-center h-full text-white">
                                    <h2 class="text-3xl font-bold mb-2">Halo, Admin!</h2>
                                    <p class="text-blue-100 max-w-lg mb-4">
                                        Pantauan hari ini menunjukkan peningkatan debit air di
                                        sektor utara. Harap periksa laporan masyarakat yang masuk.
                                    </p>
                                    <div class="flex gap-3">
                                        <button
                                            class="bg-white/20 hover:bg-white/30 backdrop-blur-sm text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors border border-white/10">
                                            Lihat Notifikasi
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Stats Grid -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                            <!-- Card 1 -->
                            <div
                                class="bg-white dark:bg-surface-dark-lighter p-5 rounded-xl border border-slate-200 dark:border-slate-700/50 shadow-sm flex flex-col">
                                <div class="flex justify-between items-start mb-4">
                                    <div class="p-2 bg-danger/10 text-danger rounded-lg">
                                        <span class="material-symbols-outlined">flood</span>
                                    </div>
                                    <span class="text-xs font-semibold bg-danger/20 text-danger px-2 py-1 rounded-full">+2
                                        Level</span>
                                </div>
                                <p class="text-slate-500 dark:text-[#8e99cc] text-sm font-medium">
                                    Status Banjir
                                </p>
                                <h3 class="text-2xl font-bold text-slate-900 dark:text-white mt-1">
                                    Siaga 1
                                </h3>
                            </div>
                            <!-- Card 2 -->
                            <div
                                class="bg-white dark:bg-surface-dark-lighter p-5 rounded-xl border border-slate-200 dark:border-slate-700/50 shadow-sm flex flex-col">
                                <div class="flex justify-between items-start mb-4">
                                    <div class="p-2 bg-primary/10 text-primary rounded-lg">
                                        <span class="material-symbols-outlined">sensors</span>
                                    </div>
                                    <span
                                        class="text-xs font-semibold bg-slate-200 dark:bg-slate-700 text-slate-600 dark:text-slate-300 px-2 py-1 rounded-full">80%
                                        Online</span>
                                </div>
                                <p class="text-slate-500 dark:text-[#8e99cc] text-sm font-medium">
                                    Pos Pantau Aktif
                                </p>
                                <h3 class="text-2xl font-bold text-slate-900 dark:text-white mt-1">
                                    12/15
                                </h3>
                            </div>
                            <!-- Card 3 -->
                            <div
                                class="bg-white dark:bg-surface-dark-lighter p-5 rounded-xl border border-slate-200 dark:border-slate-700/50 shadow-sm flex flex-col">
                                <div class="flex justify-between items-start mb-4">
                                    <div class="p-2 bg-warning/10 text-warning rounded-lg">
                                        <span class="material-symbols-outlined">pending_actions</span>
                                    </div>
                                    <span class="text-xs font-semibold bg-warning/20 text-warning px-2 py-1 rounded-full">+3
                                        Baru</span>
                                </div>
                                <p class="text-slate-500 dark:text-[#8e99cc] text-sm font-medium">
                                    Laporan Pending
                                </p>
                                <h3 class="text-2xl font-bold text-slate-900 dark:text-white mt-1">
                                    8
                                </h3>
                            </div>
                            <!-- Card 4 -->
                            <div
                                class="bg-white dark:bg-surface-dark-lighter p-5 rounded-xl border border-slate-200 dark:border-slate-700/50 shadow-sm flex flex-col">
                                <div class="flex justify-between items-start mb-4">
                                    <div class="p-2 bg-success/10 text-success rounded-lg">
                                        <span class="material-symbols-outlined">analytics</span>
                                    </div>
                                    <span
                                        class="text-xs font-semibold bg-danger/20 text-danger px-2 py-1 rounded-full">Tinggi</span>
                                </div>
                                <p class="text-slate-500 dark:text-[#8e99cc] text-sm font-medium">
                                    Indeks Risiko
                                </p>
                                <h3 class="text-2xl font-bold text-slate-900 dark:text-white mt-1">
                                    94.5
                                </h3>
                            </div>
                        </div>
                        <!-- Main Content Grid -->
                        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 h-auto min-h-[400px]">
                            <!-- Map Section -->
                            <div
                                class="xl:col-span-2 bg-white dark:bg-surface-dark-lighter rounded-xl border border-slate-200 dark:border-slate-700/50 shadow-sm overflow-hidden flex flex-col">
                                <div
                                    class="p-5 border-b border-slate-200 dark:border-slate-700/50 flex justify-between items-center">
                                    <h3 class="font-semibold text-lg">Peta Sebaran Pos Pantau</h3>
                                    <div class="flex gap-2">
                                        <button
                                            class="p-1.5 hover:bg-slate-100 dark:hover:bg-slate-700 rounded text-slate-500">
                                            <span class="material-symbols-outlined text-[20px]">filter_list</span>
                                        </button>
                                        <button
                                            class="p-1.5 hover:bg-slate-100 dark:hover:bg-slate-700 rounded text-slate-500">
                                            <span class="material-symbols-outlined text-[20px]">fullscreen</span>
                                        </button>
                                    </div>
                                </div>
                                <div class="flex-1 relative bg-slate-100 dark:bg-[#181d35] min-h-[350px]">
                                    <!-- Placeholder Map Image -->
                                    <div class="absolute inset-0 bg-cover bg-center"
                                        data-alt="Stylized dark map of Jakarta city with location pins indicating monitoring posts"
                                        data-location="Jakarta"
                                        style="
                      background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuDPMycUVVjT8mKgwy_vsiQIObmHzfq4XPHEwGJgUvq755m4Uut1olwf7334L3hrr87598-ho1Frcam_xjbBjDlQHm1IVPMEOvxL_yFodoWHS4_GljXr1O7gXoaC8Hgyik3ErpsyD0wXGv5x__WqSkQsWqmqB4amkzGZGWSfUWCynN3FF7MFgnjDwQx6qpuqm46Fc4nlhqZKPT5SksglM8SoiL1_XffwcxentLanOGLF8iANfqbKgrtoxAO8zvaJdlm2K5saKABUTPLy');
                      filter: grayscale(100%) invert(85%) opacity(0.5);
                    ">
                                    </div>
                                    <!-- Map Overlay Controls -->
                                    <div class="absolute top-4 left-4 right-4 flex justify-between items-start">
                                        <div
                                            class="bg-white dark:bg-surface-dark shadow-lg rounded-lg flex items-center p-1 w-full max-w-xs">
                                            <span class="material-symbols-outlined text-slate-400 px-2">search</span>
                                            <input
                                                class="bg-transparent border-none focus:ring-0 text-sm w-full text-slate-800 dark:text-white"
                                                placeholder="Cari lokasi pos..." type="text" />
                                        </div>
                                        <div class="flex flex-col gap-2">
                                            <button
                                                class="bg-white dark:bg-surface-dark p-2 rounded-lg shadow-lg hover:bg-slate-50 dark:hover:bg-surface-dark-lighter text-slate-700 dark:text-white">
                                                <span class="material-symbols-outlined text-[20px]">add</span>
                                            </button>
                                            <button
                                                class="bg-white dark:bg-surface-dark p-2 rounded-lg shadow-lg hover:bg-slate-50 dark:hover:bg-surface-dark-lighter text-slate-700 dark:text-white">
                                                <span class="material-symbols-outlined text-[20px]">remove</span>
                                            </button>
                                        </div>
                                    </div>
                                    <!-- Pins (Absolute positioned for demo) -->
                                    <div
                                        class="absolute top-[40%] left-[30%] translate-x-[-50%] translate-y-[-50%] flex flex-col items-center group cursor-pointer">
                                        <div
                                            class="bg-danger text-white text-[10px] font-bold px-2 py-0.5 rounded shadow-sm opacity-0 group-hover:opacity-100 transition-opacity mb-1 whitespace-nowrap">
                                            Pos Ciliwung 1 (Bahaya)
                                        </div>
                                        <span
                                            class="material-symbols-outlined text-danger text-4xl drop-shadow-md">location_on</span>
                                    </div>
                                    <div
                                        class="absolute top-[60%] left-[60%] translate-x-[-50%] translate-y-[-50%] flex flex-col items-center group cursor-pointer">
                                        <div
                                            class="bg-success text-white text-[10px] font-bold px-2 py-0.5 rounded shadow-sm opacity-0 group-hover:opacity-100 transition-opacity mb-1 whitespace-nowrap">
                                            Pos Katulampa (Aman)
                                        </div>
                                        <span
                                            class="material-symbols-outlined text-success text-4xl drop-shadow-md">location_on</span>
                                    </div>
                                </div>
                            </div>
                            <!-- Recent Reports List -->
                            <div
                                class="bg-white dark:bg-surface-dark-lighter rounded-xl border border-slate-200 dark:border-slate-700/50 shadow-sm flex flex-col">
                                <div
                                    class="p-5 border-b border-slate-200 dark:border-slate-700/50 flex justify-between items-center">
                                    <h3 class="font-semibold text-lg">Laporan Masuk</h3>
                                    <a class="text-primary text-sm font-medium hover:underline" href="#">Lihat
                                        Semua</a>
                                </div>
                                <div class="flex-1 overflow-y-auto max-h-[400px] p-2 space-y-1">
                                    <!-- List Item 1 -->
                                    <div
                                        class="p-3 hover:bg-slate-50 dark:hover:bg-[#1e253e] rounded-lg transition-colors cursor-pointer group">
                                        <div class="flex justify-between items-start mb-1">
                                            <div class="flex items-center gap-2">
                                                <div class="w-2 h-2 rounded-full bg-danger animate-pulse"></div>
                                                <span
                                                    class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Masyarakat</span>
                                            </div>
                                            <span class="text-xs text-slate-400">2m ago</span>
                                        </div>
                                        <h4
                                            class="text-sm font-semibold text-slate-800 dark:text-slate-200 mb-0.5 group-hover:text-primary transition-colors">
                                            Banjir setinggi lutut di Jl. Sudirman
                                        </h4>
                                        <p class="text-xs text-slate-500 dark:text-slate-400 truncate">
                                            Lokasi: Kec. Tanah Abang, Kel. Karet Tengsin
                                        </p>
                                    </div>
                                    <!-- List Item 2 -->
                                    <div
                                        class="p-3 hover:bg-slate-50 dark:hover:bg-[#1e253e] rounded-lg transition-colors cursor-pointer group">
                                        <div class="flex justify-between items-start mb-1">
                                            <div class="flex items-center gap-2">
                                                <div class="w-2 h-2 rounded-full bg-warning"></div>
                                                <span
                                                    class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Petugas</span>
                                            </div>
                                            <span class="text-xs text-slate-400">15m ago</span>
                                        </div>
                                        <h4
                                            class="text-sm font-semibold text-slate-800 dark:text-slate-200 mb-0.5 group-hover:text-primary transition-colors">
                                            Pintu Air Manggarai Siaga 3
                                        </h4>
                                        <p class="text-xs text-slate-500 dark:text-slate-400 truncate">
                                            Lokasi: Kec. Tebet, Kel. Manggarai
                                        </p>
                                    </div>
                                    <!-- List Item 3 -->
                                    <div
                                        class="p-3 hover:bg-slate-50 dark:hover:bg-[#1e253e] rounded-lg transition-colors cursor-pointer group">
                                        <div class="flex justify-between items-start mb-1">
                                            <div class="flex items-center gap-2">
                                                <div class="w-2 h-2 rounded-full bg-success"></div>
                                                <span
                                                    class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">System</span>
                                            </div>
                                            <span class="text-xs text-slate-400">1h ago</span>
                                        </div>
                                        <h4
                                            class="text-sm font-semibold text-slate-800 dark:text-slate-200 mb-0.5 group-hover:text-primary transition-colors">
                                            Sensor #402 Online Kembali
                                        </h4>
                                        <p class="text-xs text-slate-500 dark:text-slate-400 truncate">
                                            Status: Normal Operation
                                        </p>
                                    </div>
                                    <!-- List Item 4 -->
                                    <div
                                        class="p-3 hover:bg-slate-50 dark:hover:bg-[#1e253e] rounded-lg transition-colors cursor-pointer group">
                                        <div class="flex justify-between items-start mb-1">
                                            <div class="flex items-center gap-2">
                                                <div class="w-2 h-2 rounded-full bg-danger"></div>
                                                <span
                                                    class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Masyarakat</span>
                                            </div>
                                            <span class="text-xs text-slate-400">2h ago</span>
                                        </div>
                                        <h4
                                            class="text-sm font-semibold text-slate-800 dark:text-slate-200 mb-0.5 group-hover:text-primary transition-colors">
                                            Pohon tumbang menghambat aliran
                                        </h4>
                                        <p class="text-xs text-slate-500 dark:text-slate-400 truncate">
                                            Lokasi: Kali Pesanggrahan
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Charts Section -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Line Chart -->
                            <div
                                class="bg-white dark:bg-surface-dark-lighter p-6 rounded-xl border border-slate-200 dark:border-slate-700/50 shadow-sm">
                                <div class="flex justify-between items-center mb-6">
                                    <div>
                                        <h3 class="text-base font-medium text-slate-900 dark:text-white">
                                            Tren Tinggi Muka Air (24 Jam)
                                        </h3>
                                        <p class="text-xs text-slate-500 dark:text-[#8e99cc]">
                                            Rata-rata seluruh pos pantau
                                        </p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-2xl font-bold tracking-tight">180 cm</p>
                                        <p class="text-xs text-success font-medium flex items-center justify-end gap-1">
                                            <span class="material-symbols-outlined text-sm">trending_up</span>
                                            +10%
                                        </p>
                                    </div>
                                </div>
                                <div class="relative w-full h-[200px]">
                                    <svg class="w-full h-full overflow-visible" preserveaspectratio="none"
                                        viewbox="0 0 500 200">
                                        <defs>
                                            <lineargradient id="gradientPrimary" x1="0" x2="0"
                                                y1="0" y2="1">
                                                <stop offset="0%" stop-color="#1f44f9" stop-opacity="0.3"></stop>
                                                <stop offset="100%" stop-color="#1f44f9" stop-opacity="0"></stop>
                                            </lineargradient>
                                        </defs>
                                        <!-- Grid Lines -->
                                        <line stroke="#334155" stroke-dasharray="4" stroke-opacity="0.2" x1="0"
                                            x2="500" y1="150" y2="150"></line>
                                        <line stroke="#334155" stroke-dasharray="4" stroke-opacity="0.2" x1="0"
                                            x2="500" y1="100" y2="100"></line>
                                        <line stroke="#334155" stroke-dasharray="4" stroke-opacity="0.2" x1="0"
                                            x2="500" y1="50" y2="50"></line>
                                        <!-- The Chart Path -->
                                        <path
                                            d="M0,150 C50,150 50,100 100,90 C150,80 150,120 200,110 C250,100 250,40 300,50 C350,60 350,140 400,130 C450,120 450,80 500,60"
                                            fill="none" stroke="#1f44f9" stroke-linecap="round"
                                            stroke-linejoin="round" stroke-width="3"></path>
                                        <path
                                            d="M0,150 C50,150 50,100 100,90 C150,80 150,120 200,110 C250,100 250,40 300,50 C350,60 350,140 400,130 C450,120 450,80 500,60 V200 H0 Z"
                                            fill="url(#gradientPrimary)" stroke="none"></path>
                                        <!-- Dots -->
                                        <circle class="dark:stroke-[#21284a] stroke-white" cx="100" cy="90"
                                            fill="#1f44f9" r="4" stroke-width="2"></circle>
                                        <circle class="dark:stroke-[#21284a] stroke-white" cx="300" cy="50"
                                            fill="#1f44f9" r="4" stroke-width="2"></circle>
                                        <circle class="dark:stroke-[#21284a] stroke-white" cx="500" cy="60"
                                            fill="#1f44f9" r="4" stroke-width="2"></circle>
                                    </svg>
                                </div>
                                <div class="flex justify-between mt-2 text-xs text-slate-400 font-medium">
                                    <span>00:00</span>
                                    <span>06:00</span>
                                    <span>12:00</span>
                                    <span>18:00</span>
                                    <span>24:00</span>
                                </div>
                            </div>
                            <!-- Bar Chart -->
                            <div
                                class="bg-white dark:bg-surface-dark-lighter p-6 rounded-xl border border-slate-200 dark:border-slate-700/50 shadow-sm flex flex-col">
                                <div class="flex justify-between items-center mb-6">
                                    <div>
                                        <h3 class="text-base font-medium text-slate-900 dark:text-white">
                                            Sumber Laporan
                                        </h3>
                                        <p class="text-xs text-slate-500 dark:text-[#8e99cc]">
                                            Petugas vs Masyarakat
                                        </p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-2xl font-bold tracking-tight">45</p>
                                        <p class="text-xs text-slate-500">Total Hari Ini</p>
                                    </div>
                                </div>
                                <div class="flex-1 flex items-end justify-center gap-12 pb-4">
                                    <div class="flex flex-col items-center gap-2 group w-24">
                                        <span
                                            class="text-sm font-bold text-primary opacity-0 group-hover:opacity-100 transition-opacity transform translate-y-2 group-hover:translate-y-0">65%</span>
                                        <div
                                            class="w-full bg-slate-100 dark:bg-[#181d35] rounded-t-lg relative h-40 overflow-hidden">
                                            <div class="absolute bottom-0 w-full bg-primary transition-all duration-500 hover:bg-primary-dark"
                                                style="height: 65%"></div>
                                        </div>
                                        <span class="text-xs font-medium text-slate-500 dark:text-[#8e99cc]">Petugas</span>
                                    </div>
                                    <div class="flex flex-col items-center gap-2 group w-24">
                                        <span
                                            class="text-sm font-bold text-warning opacity-0 group-hover:opacity-100 transition-opacity transform translate-y-2 group-hover:translate-y-0">35%</span>
                                        <div
                                            class="w-full bg-slate-100 dark:bg-[#181d35] rounded-t-lg relative h-40 overflow-hidden">
                                            <div class="absolute bottom-0 w-full bg-warning transition-all duration-500 hover:bg-orange-600"
                                                style="height: 35%"></div>
                                        </div>
                                        <span
                                            class="text-xs font-medium text-slate-500 dark:text-[#8e99cc]">Masyarakat</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </body>
@endsection
