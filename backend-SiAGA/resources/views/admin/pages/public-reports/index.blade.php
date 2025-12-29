@extends('admin.layouts.app')

@section('breadcrumbs')
    <span class="material-symbols-outlined text-sm ...">chevron_right</span>
    <span class="text-sm font-medium text-slate-900 dark:text-white">Manajemen Laporan Masyarakat</span>
@endsection

@section('content')
    <div class="flex h-screen w-full">
        @include('admin.includes.sidebar')

        <main class="flex-1 flex flex-col h-full overflow-hidden relative bg-background-light dark:bg-background-dark">
            @include('admin.includes.header')

            <div class="flex-1 overflow-auto">
                <div class="max-w-7xl mx-auto px-6 py-8">
                    <!-- PageHeading -->
                    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-8">
                        <div>
                            <h2 class="text-3xl font-black tracking-tight text-white mb-2">
                                Manajemen Laporan Masyarakat
                            </h2>
                            <p class="text-slate-400">
                                Verifikasi laporan Masyarakat.
                            </p>
                        </div>
                    </div>

                    <!-- Card -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <div
                            class="bg-surface-dark border border-slate-800 rounded-xl p-6 relative overflow-hidden group hover:border-slate-700 transition-all">
                            <div class="absolute right-0 top-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity">
                                <span class="material-symbols-outlined text-8xl text-white">today</span>
                            </div>
                            <p class="text-slate-400 font-medium mb-2">Total Laporan Hari Ini</p>
                            <div class="flex items-end gap-3">
                                <span class="text-4xl font-bold text-white">{{ $stats['total_today'] }}</span>
                            </div>
                        </div>

                        <div
                            class="bg-surface-dark border border-slate-800 rounded-xl p-6 relative overflow-hidden group hover:border-slate-700 transition-all">
                            <div class="absolute right-0 top-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity">
                                <span class="material-symbols-outlined text-8xl text-white">pending</span>
                            </div>
                            <p class="text-slate-400 font-medium mb-2">Menunggu Verifikasi</p>
                            <div class="flex items-end gap-3">
                                <span class="text-4xl font-bold text-white">{{ $stats['pending'] }}</span>
                            </div>
                        </div>

                        <div
                            class="bg-surface-dark border border-slate-800 rounded-xl p-6 relative overflow-hidden group hover:border-slate-700 transition-all">
                            <div class="absolute right-0 top-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity">
                                <span class="material-symbols-outlined text-8xl text-white">check_circle</span>
                            </div>
                            <p class="text-slate-400 font-medium mb-2">Terverifikasi</p>
                            <div class="flex items-end gap-3">
                                <span class="text-4xl font-bold text-white">{{ $stats['verified'] }}</span>
                            </div>
                        </div>
                    </div>

                    <form id="filterForm" action="{{ route('officer-reports.index') }}" method="GET"
                        class="bg-surface-dark border border-slate-800 rounded-t-xl p-4 flex flex-col md:flex-row gap-4 items-center justify-between">

                        <div class="w-full md:w-96 relative group">
                            <span
                                class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-500 group-focus-within:text-primary transition-colors">search</span>
                            </span>
                            <input name="search" value="{{ request('search') }}"
                                class="w-full bg-background-dark border border-slate-700 text-white text-sm rounded-lg focus:ring-primary focus:border-primary block pl-10 p-2.5 placeholder-slate-500 transition-all"
                                placeholder="Cari petugas, lokasi, atau ID..." type="text" />
                        </div>

                        <div class="flex flex-wrap gap-2 w-full md:w-auto">
                            <div class="relative">
                                <select name="status" onchange="this.form.submit()"
                                    class="appearance-none bg-gray-50 dark:bg-surface-dark-lighter text-gray-700 dark:text-gray-300 text-sm rounded-lg px-4 py-2.5 pr-10 border-none focus:ring-2 focus:ring-primary/50 cursor-pointer">
                                    <option {{ request('status') == 'Semua Status' ? 'selected' : '' }}>Semua Status
                                    </option>
                                    <option {{ request('status') == 'Terverifikasi' ? 'selected' : '' }}>Terverifikasi
                                    </option>
                                    <option {{ request('status') == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                                    <option {{ request('status') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                                </select>
                                <span class="pointer-events-none absolute right-2 top-1/2 -translate-y-1/2 text-gray-400">
                                    <span class="material-symbols-outlined text-[20px]">expand_more</span>
                                </span>
                            </div>

                            <div class="relative">
                                <select name="date" onchange="this.form.submit()"
                                    class="appearance-none bg-gray-50 dark:bg-surface-dark-lighter text-gray-700 dark:text-gray-300 text-sm rounded-lg px-4 py-2.5 pr-10 border-none focus:ring-2 focus:ring-primary/50 cursor-pointer">
                                    <option value="">Semua Waktu</option>
                                    <option {{ request('date') == '24 Jam Terakhir' ? 'selected' : '' }}>24 Jam Terakhir
                                    </option>
                                    <option {{ request('date') == 'Minggu Ini' ? 'selected' : '' }}>Minggu Ini</option>
                                    <option {{ request('date') == 'Bulan Ini' ? 'selected' : '' }}>Bulan Ini</option>
                                </select>
                                <span class="pointer-events-none absolute right-2 top-1/2 -translate-y-1/2 text-gray-400">
                                    <span class="material-symbols-outlined text-[20px]">calendar_today</span>
                                </span>
                            </div>

                            <a href="{{ route('officer-reports.export', request()->query()) }}" target="_blank"
                                class="flex items-center gap-2 bg-primary hover:bg-primary/90 text-white px-4 py-2.5 rounded-lg text-sm font-medium transition-colors shadow-lg shadow-primary/20">
                                <span class="material-symbols-outlined text-[20px]">file_download</span>
                                <span class="hidden lg:inline">Export Data</span>
                            </a>
                        </div>

                        <button type="submit" class="hidden">Cari</button>
                    </form>

                    <div class="bg-surface-dark border border-slate-800 border-t-0 rounded-b-xl overflow-hidden shadow-sm">
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left text-slate-400">
                                <thead
                                    class="text-xs text-slate-400 uppercase bg-surface-dark-lighter border-b border-slate-700">
                                    <tr>
                                        <th
                                            class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                            Waktu Lapor</th>
                                        <th
                                            class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                            Petugas</th>
                                        <th
                                            class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                            Lokasi Pos Pantau</th>
                                        <th
                                            class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                            Tinggi Air</th>
                                        <th
                                            class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                            Validasi</th>
                                        <th
                                            class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 text-right">
                                            Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                                    @forelse($reports as $report)
                                        <tr
                                            class="group hover:bg-gray-50 dark:hover:bg-surface-dark-lighter transition-colors">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                    {{ $report->created_at->translatedFormat('d M Y') }}
                                                </div>
                                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                                    {{ $report->created_at->format('H:i') }} WIB
                                                </div>
                                            </td>

                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center gap-3">
                                                    @if ($report->officer->photo)
                                                        <img src="{{ asset('storage/' . $report->officer->photo) }}"
                                                            class="h-8 w-8 rounded-full object-cover border border-gray-600">
                                                    @else
                                                        <div
                                                            class="h-8 w-8 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-xs font-bold text-gray-600 dark:text-gray-300">
                                                            {{ substr($report->officer->name ?? 'U', 0, 2) }}
                                                        </div>
                                                    @endif
                                                    <div class="text-sm text-gray-700 dark:text-gray-300">
                                                        {{ $report->officer->name ?? 'Unknown' }}
                                                    </div>
                                                </div>
                                            </td>

                                            <td
                                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400">
                                                {{ $report->station->name ?? 'Unknown Station' }}
                                            </td>

                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @php
                                                    // 1. Hitung Status secara Real-time berdasarkan Threshold Stasiun
                                                    $currentStatus = 'normal';

                                                    // Asumsi: Relasi report ke station bernama 'station'
                                                    // Cek level air terhadap batas AWAS
                                                    if ($report->water_level >= $report->station->threshold_awas) {
                                                        $currentStatus = 'awas';
                                                    }
                                                    // Cek level air terhadap batas SIAGA
                                                    elseif ($report->water_level >= $report->station->threshold_siaga) {
                                                        $currentStatus = 'siaga';
                                                    }

                                                    // 2. Tentukan Warna Badge berdasarkan Status hasil hitungan di atas
                                                    $statusColor = match ($currentStatus) {
                                                        'awas'
                                                            => 'bg-red-50 text-red-700 border-red-200 dark:bg-red-900/30 dark:text-red-400 dark:border-red-900/50',
                                                        'siaga'
                                                            => 'bg-orange-50 text-orange-700 border-orange-200 dark:bg-orange-900/30 dark:text-orange-400 dark:border-orange-900/50',
                                                        default
                                                            => 'bg-green-50 text-green-700 border-green-200 dark:bg-green-900/30 dark:text-green-400 dark:border-green-900/50',
                                                    };

                                                    // 3. Tentukan Warna Titik (Dot)
                                                    $dotColor = match ($currentStatus) {
                                                        'awas' => 'bg-red-600 dark:bg-red-400',
                                                        'siaga' => 'bg-orange-600 dark:bg-orange-400',
                                                        default => 'bg-green-600 dark:bg-green-400',
                                                    };
                                                @endphp
                                                <span
                                                    class="inline-flex items-center gap-1.5 rounded-full border px-2.5 py-1 text-xs font-medium {{ $statusColor }}">
                                                    <span
                                                        class="h-1.5 w-1.5 rounded-full {{ $dotColor }} animate-pulse"></span>
                                                    {{ $report->water_level }} cm
                                                    ({{ ucfirst($currentStatus) }})
                                                </span>
                                            </td>

                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if ($report->validation_status == 'approved')
                                                    <span
                                                        class="inline-flex items-center rounded-md bg-green-50 dark:bg-green-900/20 px-2 py-1 text-xs font-medium text-green-700 dark:text-green-400 ring-1 ring-inset ring-green-600/20 dark:ring-green-500/30">Terverifikasi</span>
                                                @elseif($report->validation_status == 'rejected')
                                                    <span
                                                        class="inline-flex items-center rounded-md bg-red-50 dark:bg-red-900/20 px-2 py-1 text-xs font-medium text-red-700 dark:text-red-400 ring-1 ring-inset ring-red-600/20 dark:ring-red-500/30">Ditolak</span>
                                                @else
                                                    <span
                                                        class="inline-flex items-center rounded-md bg-gray-100 dark:bg-gray-800 px-2 py-1 text-xs font-medium text-gray-600 dark:text-gray-400 ring-1 ring-inset ring-gray-500/10 dark:ring-gray-700">Menunggu</span>
                                                @endif
                                            </td>

                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <a href="{{ route('officer-reports.show', $report->id) }}"
                                                    class="text-primary hover:text-primary/80 dark:hover:text-primary/70 transition-colors mr-2">
                                                    Detail
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6"
                                                class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                                                <div class="flex flex-col items-center justify-center gap-2">
                                                    <span class="material-symbols-outlined text-4xl opacity-50">inbox</span>
                                                    <p>Belum ada data laporan.</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div
                            class="flex items-center justify-between border-t border-slate-200 px-6 py-4 dark:border-[#21284a]">
                            <p class="text-sm text-slate-500 dark:text-[#8e99cc]">
                                Menampilkan
                                <span
                                    class="font-semibold text-slate-900 dark:text-white">{{ $reports->firstItem() }}</span>
                                sampai
                                <span
                                    class="font-semibold text-slate-900 dark:text-white">{{ $reports->lastItem() }}</span>
                                dari
                                <span class="font-semibold text-slate-900 dark:text-white">{{ $reports->total() }}</span>
                                hasil
                            </p>

                            <div class="flex gap-2">
                                {{-- Tombol Sebelumnya --}}
                                <a href="{{ $reports->previousPageUrl() }}"
                                    class="flex size-9 items-center justify-center rounded-lg border ... {{ $reports->onFirstPage() ? 'opacity-50 pointer-events-none' : '' }}">
                                    <span class="material-symbols-outlined text-sm">chevron_left</span>
                                </a>

                                {{-- Nomor Halaman --}}
                                @foreach ($reports->getUrlRange(1, $reports->lastPage()) as $page => $url)
                                    <a href="{{ $url }}"
                                        class="flex size-9 items-center justify-center rounded-lg {{ $page == $reports->currentPage() ? 'bg-primary text-white' : 'border border-slate-200 bg-white text-slate-500' }}">
                                        {{ $page }}
                                    </a>
                                @endforeach

                                {{-- Tombol Selanjutnya --}}
                                <a href="{{ $reports->nextPageUrl() }}"
                                    class="flex size-9 items-center justify-center rounded-lg border ... {{ !$reports->hasMorePages() ? 'opacity-50 pointer-events-none' : '' }}">
                                    <span class="material-symbols-outlined text-sm">chevron_right</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
@endsection

@section('script')
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        primary: "#607afb",
                        "background-light": "#f5f6f8",
                        "background-dark": "#0f1323",
                        "surface-dark": "#1a1f36",
                        "surface-dark-lighter": "#242a45",
                    },
                    fontFamily: {
                        display: ["Public Sans", "sans-serif"],
                        sans: ["Public Sans", "sans-serif"],
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
