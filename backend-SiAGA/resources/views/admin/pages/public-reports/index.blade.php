@extends('admin.layouts.app')

@section('breadcrumbs')
    <span class="material-symbols-outlined text-sm text-slate-500">chevron_right</span>
    <span class="text-sm font-medium text-slate-900 dark:text-white">Manajemen Laporan Masyarakat</span>
@endsection

@section('content')
    <div class="flex h-screen w-full">
        @include('admin.includes.sidebar')

        <main class="flex-1 flex flex-col h-full overflow-hidden relative bg-background-light dark:bg-background-dark">
            @include('admin.includes.header')

            <div class="flex-1 overflow-auto">
                <div class="max-w-7xl mx-auto px-6 py-8">
                    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-8">
                        <div>
                            <h2 class="text-3xl font-black tracking-tight text-white mb-2">
                                Laporan Masyarakat
                            </h2>
                            <p class="text-slate-400">
                                Verifikasi dan tindak lanjuti laporan banjir dari warga.
                            </p>
                        </div>
                    </div>

                    {{--
                        CATATAN: Pastikan Controller mengirim variabel $stats.
                        Jika belum, hapus bagian ini atau tambahkan logika di Controller.
                    --}}
                    @if (isset($stats))
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                            <div
                                class="bg-surface-dark border border-slate-800 rounded-xl p-6 relative overflow-hidden group hover:border-slate-700 transition-all">
                                <div class="absolute right-0 top-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity">
                                    <span class="material-symbols-outlined text-8xl text-white">today</span>
                                </div>
                                <p class="text-slate-400 font-medium mb-2">Laporan Hari Ini</p>
                                <div class="flex items-end gap-3">
                                    <span class="text-4xl font-bold text-white">{{ $stats['total_today'] ?? 0 }}</span>
                                </div>
                            </div>

                            <div
                                class="bg-surface-dark border border-slate-800 rounded-xl p-6 relative overflow-hidden group hover:border-slate-700 transition-all">
                                <div class="absolute right-0 top-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity">
                                    <span class="material-symbols-outlined text-8xl text-white">pending</span>
                                </div>
                                <p class="text-slate-400 font-medium mb-2">Menunggu Verifikasi</p>
                                <div class="flex items-end gap-3">
                                    <span class="text-4xl font-bold text-white">{{ $stats['pending'] ?? 0 }}</span>
                                </div>
                            </div>

                            <div
                                class="bg-surface-dark border border-slate-800 rounded-xl p-6 relative overflow-hidden group hover:border-slate-700 transition-all">
                                <div class="absolute right-0 top-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity">
                                    <span class="material-symbols-outlined text-8xl text-white">warning</span>
                                </div>
                                <p class="text-slate-400 font-medium mb-2">Laporan Darurat</p>
                                <div class="flex items-end gap-3">
                                    <span class="text-4xl font-bold text-white">{{ $stats['emergency'] ?? 0 }}</span>
                                </div>
                            </div>
                        </div>
                    @endif

                    <form id="filterForm" action="{{ route('public-reports.index') }}" method="GET"
                        class="bg-surface-dark border border-slate-800 rounded-t-xl p-4 flex flex-col md:flex-row gap-4 items-center justify-between">

                        <div class="w-full md:w-96 relative group">
                            <span
                                class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-500 group-focus-within:text-primary transition-colors">search</span>
                            <input name="search" value="{{ request('search') }}"
                                class="w-full bg-background-dark border border-slate-700 text-white text-sm rounded-lg focus:ring-primary focus:border-primary block pl-10 p-2.5 placeholder-slate-500 transition-all"
                                placeholder="Cari kode, lokasi, atau pelapor..." type="text" />
                        </div>

                        <div class="flex flex-wrap gap-2 w-full md:w-auto">
                            <div class="relative">
                                <select name="status" onchange="this.form.submit()"
                                    class="appearance-none bg-gray-50 dark:bg-surface-dark-lighter text-gray-700 dark:text-gray-300 text-sm rounded-lg px-4 py-2.5 pr-10 border-none focus:ring-2 focus:ring-primary/50 cursor-pointer">
                                    <option value="">Semua Status</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu
                                    </option>
                                    <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>
                                        Diproses</option>
                                    <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai
                                    </option>
                                    <option value="emergency" {{ request('status') == 'emergency' ? 'selected' : '' }}>
                                        Darurat</option>
                                </select>
                                <span class="pointer-events-none absolute right-2 top-1/2 -translate-y-1/2 text-gray-400">
                                    <span class="material-symbols-outlined text-[20px]">expand_more</span>
                                </span>
                            </div>

                            <div class="relative">
                                <select name="date" onchange="this.form.submit()"
                                    class="appearance-none bg-gray-50 dark:bg-surface-dark-lighter text-gray-700 dark:text-gray-300 text-sm rounded-lg px-4 py-2.5 pr-10 border-none focus:ring-2 focus:ring-primary/50 cursor-pointer">
                                    <option value="">Semua Waktu</option>
                                    <option value="24 Jam Terakhir"
                                        {{ request('date') == '24 Jam Terakhir' ? 'selected' : '' }}>24 Jam Terakhir
                                    </option>
                                    <option value="Minggu Ini" {{ request('date') == 'Minggu Ini' ? 'selected' : '' }}>
                                        Minggu Ini</option>
                                    <option value="Bulan Ini" {{ request('date') == 'Bulan Ini' ? 'selected' : '' }}>Bulan
                                        Ini</option>
                                </select>
                                <span class="pointer-events-none absolute right-2 top-1/2 -translate-y-1/2 text-gray-400">
                                    <span class="material-symbols-outlined text-[20px]">calendar_today</span>
                                </span>
                            </div>

                            <a href="{{ route('public-reports.export', request()->query()) }}" target="_blank"
                                class="flex items-center gap-2 bg-primary hover:bg-primary/90 text-white px-4 py-2.5 rounded-lg text-sm font-medium transition-colors shadow-lg shadow-primary/20">
                                <span class="material-symbols-outlined text-[20px]">file_download</span>
                                <span class="hidden lg:inline">Export</span>
                            </a>
                        </div>
                    </form>

                    <div class="bg-surface-dark border border-slate-800 border-t-0 rounded-b-xl overflow-hidden shadow-sm">
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left text-slate-400">
                                <thead
                                    class="text-xs text-slate-400 uppercase bg-surface-dark-lighter border-b border-slate-700">
                                    <tr>
                                        <th class="px-6 py-4 font-semibold">Waktu / Kode</th>
                                        <th class="px-6 py-4 font-semibold">Pelapor</th>
                                        <th class="px-6 py-4 font-semibold">Lokasi Kejadian</th>
                                        <th class="px-6 py-4 font-semibold">Tinggi Air</th>
                                        <th class="px-6 py-4 font-semibold">Status</th>
                                        <th class="px-6 py-4 font-semibold text-right">Aksi</th>
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
                                                <div class="text-xs text-gray-500 dark:text-gray-400 mb-1">
                                                    {{ $report->created_at->format('H:i') }} WIB
                                                </div>
                                                <span
                                                    class="inline-flex items-center rounded-md bg-gray-400/10 px-2 py-1 text-xs font-medium text-gray-400 ring-1 ring-inset ring-gray-400/20">
                                                    {{ $report->report_code }}
                                                </span>
                                            </td>

                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center gap-3">
                                                    {{-- Avatar Inisial (User biasanya tidak wajib foto) --}}
                                                    <div
                                                        class="h-8 w-8 rounded-full bg-primary/20 flex items-center justify-center text-xs font-bold text-primary">
                                                        {{ substr($report->user->name ?? 'User', 0, 2) }}
                                                    </div>
                                                    <div class="text-sm text-gray-700 dark:text-gray-300">
                                                        {{ $report->user->name ?? 'User Terhapus' }}
                                                    </div>
                                                </div>
                                            </td>

                                            <td
                                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400">
                                                <div class="flex items-center gap-1">
                                                    <span
                                                        class="material-symbols-outlined text-[16px] text-red-500">location_on</span>
                                                    {{ Str::limit($report->location, 30) }}
                                                </div>
                                            </td>

                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="text-sm font-bold text-white">
                                                    {{ $report->water_level }} cm
                                                </span>
                                            </td>

                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @php
                                                    $statusColor = match ($report->status) {
                                                        'emergency'
                                                            => 'bg-red-50 text-red-700 ring-red-600/20 dark:bg-red-900/30 dark:text-red-400 dark:ring-red-900/50',
                                                        'selesai'
                                                            => 'bg-green-50 text-green-700 ring-green-600/20 dark:bg-green-900/30 dark:text-green-400 dark:ring-green-900/50',
                                                        'diproses'
                                                            => 'bg-blue-50 text-blue-700 ring-blue-600/20 dark:bg-blue-900/30 dark:text-blue-400 dark:ring-blue-900/50',
                                                        default
                                                            => 'bg-gray-50 text-gray-600 ring-gray-500/10 dark:bg-gray-800 dark:text-gray-400 dark:ring-gray-700',
                                                    };

                                                    $statusLabel = match ($report->status) {
                                                        'emergency' => 'Darurat',
                                                        'selesai' => 'Selesai',
                                                        'diproses' => 'Diproses',
                                                        default => 'Menunggu',
                                                    };
                                                @endphp
                                                <span
                                                    class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset {{ $statusColor }}">
                                                    {{ $statusLabel }}
                                                </span>
                                            </td>

                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <a href="{{ route('public-reports.show', $report->id) }}"
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
                                                    <p>Belum ada laporan masyarakat.</p>
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
                        sans: ["Public Sans", "sans-serif"],
                    },
                },
            },
        };
    </script>
@endsection
