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

            <main class="flex-1 flex flex-col h-full overflow-hidden relative">
                @include('admin.includes.header')

                <div class="flex-1 overflow-y-auto p-4 md:p-8 scroll-smooth">
                    <div class="max-w-7xl mx-auto space-y-6">

                        <div class="flex flex-col md:flex-row gap-6 items-stretch">
                            <div
                                class="flex-1 rounded-2xl overflow-hidden relative min-h-[160px] bg-gradient-to-r from-primary to-primary-dark shadow-lg">
                                <div
                                    class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-20">
                                </div>
                                <div class="relative z-10 p-6 md:p-8 flex flex-col justify-center h-full text-white">
                                    <h2 class="text-3xl font-bold mb-2">Halo, {{ auth()->user()->name ?? 'Admin' }}!</h2>
                                    <p class="text-blue-100 max-w-lg mb-4">
                                        Pantauan hari ini menunjukkan <strong>{{ $totalToday }} laporan baru</strong>
                                        masuk.
                                        Status tertinggi saat ini adalah <strong>{{ $highestStatus }}</strong>.
                                    </p>
                                    <div class="flex gap-3">
                                        <a href="{{ route('recap.index') }}"
                                            class="bg-white/20 hover:bg-white/30 backdrop-blur-sm text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors border border-white/10">
                                            Lihat Laporan
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">

                            <div
                                class="bg-white dark:bg-surface-dark-lighter p-5 rounded-xl border border-slate-200 dark:border-slate-700/50 shadow-sm flex flex-col">
                                <div class="flex justify-between items-start mb-4">
                                    <div class="p-2 bg-primary/10 text-primary rounded-lg">
                                        <span class="material-symbols-outlined">sensors</span>
                                    </div>
                                    <span
                                        class="text-xs font-semibold bg-slate-200 dark:bg-slate-700 text-slate-600 dark:text-slate-300 px-2 py-1 rounded-full">
                                        {{ $stationPercentage }}% Online
                                    </span>
                                </div>
                                <p class="text-slate-500 dark:text-[#8e99cc] text-sm font-medium">Pos Pantau Aktif</p>
                                <h3 class="text-2xl font-bold text-slate-900 dark:text-white mt-1">
                                    {{ $activeStations }}/{{ $totalStations }}
                                </h3>
                            </div>

                            <div
                                class="bg-white dark:bg-surface-dark-lighter p-5 rounded-xl border border-slate-200 dark:border-slate-700/50 shadow-sm flex flex-col">
                                <div class="flex justify-between items-start mb-4">
                                    <div class="p-2 bg-warning/10 text-warning rounded-lg">
                                        <span class="material-symbols-outlined">pending_actions</span>
                                    </div>
                                    @if ($totalPending > 0)
                                        <span
                                            class="text-xs font-semibold bg-warning/20 text-warning px-2 py-1 rounded-full">+{{ $totalPending }}
                                            Baru</span>
                                    @endif
                                </div>
                                <p class="text-slate-500 dark:text-[#8e99cc] text-sm font-medium">Butuh Validasi</p>
                                <h3 class="text-2xl font-bold text-slate-900 dark:text-white mt-1">{{ $totalPending }}</h3>
                            </div>

                            <div
                                class="bg-white dark:bg-surface-dark-lighter p-5 rounded-xl border border-slate-200 dark:border-slate-700/50 shadow-sm flex flex-col">
                                <div class="flex justify-between items-start mb-4">
                                    <div class="p-2 bg-success/10 text-success rounded-lg">
                                        <span class="material-symbols-outlined">analytics</span>
                                    </div>
                                    <span
                                        class="text-xs font-semibold {{ $riskIndex > 50 ? 'bg-danger/20 text-danger' : 'bg-success/20 text-success' }} px-2 py-1 rounded-full">
                                        {{ $riskIndex > 50 ? 'Tinggi' : 'Rendah' }}
                                    </span>
                                </div>
                                <p class="text-slate-500 dark:text-[#8e99cc] text-sm font-medium">Indeks Risiko</p>
                                <h3 class="text-2xl font-bold text-slate-900 dark:text-white mt-1">{{ $riskIndex }}</h3>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 h-auto min-h-[400px]">

                            <div
                                class="xl:col-span-2 bg-white dark:bg-surface-dark-lighter rounded-xl border border-slate-200 dark:border-slate-700/50 shadow-sm overflow-hidden flex flex-col">
                                <div
                                    class="p-5 border-b border-slate-200 dark:border-slate-700/50 flex justify-between items-center">
                                    <h3 class="font-semibold text-lg">Peta Sebaran Pos Pantau</h3>
                                    <a href="{{ route('map.index') }}" class="text-primary text-sm hover:underline">Buka
                                        Peta Full</a>
                                </div>
                                <div
                                    class="flex-1 relative bg-slate-100 dark:bg-[#181d35] min-h-[350px] flex items-center justify-center">
                                    {{-- Bisa diganti dengan iframe peta atau gambar statis --}}
                                    <div class="text-center text-slate-400">
                                        <span class="material-symbols-outlined text-6xl opacity-20">map</span>
                                        <p class="mt-2 text-sm">Pratinjau peta tersedia di menu "Peta Sebaran".</p>
                                    </div>
                                </div>
                            </div>

                            <div
                                class="bg-white dark:bg-surface-dark-lighter p-6 rounded-xl border border-slate-200 dark:border-slate-700/50 shadow-sm flex flex-col">
                                <div class="flex justify-between items-center mb-6">
                                    <div>
                                        <h3 class="text-base font-medium text-slate-900 dark:text-white">Sumber Laporan</h3>
                                        <p class="text-xs text-slate-500 dark:text-[#8e99cc]">Petugas vs Masyarakat</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-2xl font-bold tracking-tight">{{ $totalToday }}</p>
                                        <p class="text-xs text-slate-500">Total Hari Ini</p>
                                    </div>
                                </div>
                                <div class="flex-1 flex items-end justify-center gap-12 pb-4">
                                    <div class="flex flex-col items-center gap-2 group w-24">
                                        <span
                                            class="text-sm font-bold text-primary opacity-0 group-hover:opacity-100 transition-opacity transform translate-y-2 group-hover:translate-y-0">
                                            {{ $officerPercentage }}%
                                        </span>
                                        <div
                                            class="w-full bg-slate-100 dark:bg-[#181d35] rounded-t-lg relative h-40 overflow-hidden">
                                            <div class="absolute bottom-0 w-full bg-primary transition-all duration-1000"
                                                style="height: {{ $officerPercentage }}%"></div>
                                        </div>
                                        <span class="text-xs font-medium text-slate-500 dark:text-[#8e99cc]">Petugas</span>
                                    </div>
                                    <div class="flex flex-col items-center gap-2 group w-24">
                                        <span
                                            class="text-sm font-bold text-warning opacity-0 group-hover:opacity-100 transition-opacity transform translate-y-2 group-hover:translate-y-0">
                                            {{ $publicPercentage }}%
                                        </span>
                                        <div
                                            class="w-full bg-slate-100 dark:bg-[#181d35] rounded-t-lg relative h-40 overflow-hidden">
                                            <div class="absolute bottom-0 w-full bg-warning transition-all duration-1000"
                                                style="height: {{ $publicPercentage }}%"></div>
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
