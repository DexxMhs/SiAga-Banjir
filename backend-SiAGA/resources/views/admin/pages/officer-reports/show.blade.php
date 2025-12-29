@extends('admin.layouts.app')

@section('breadcrumbs')
    <span class="material-symbols-outlined text-sm ...">chevron_right</span>
    <a class="text-sm font-medium text-slate-500 hover:text-primary dark:text-[#8e99cc]"
        href="{{ route('officer-reports.index') }}">Manajemen Laporan Petugas</a>
    <span class="material-symbols-outlined text-sm ...">chevron_right</span>
    <span class="text-sm font-medium text-slate-900 dark:text-white">Validasi Laporan #{{ $report->report_code }}</span>
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
                        "border-dark": "#1d293d",
                        danger: "#ef4444",
                        warning: "#f59e0b",
                        success: "#10b981",
                        "text-secondary": "#8e99cc",
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

@section('css')
    <style>
        .material-symbols-outlined {
            font-variation-settings: "FILL" 0, "wght" 400, "GRAD" 0, "opsz" 24;
        }

        .material-symbols-filled {
            font-family: "Material Symbols Outlined";
            font-weight: normal;
            font-style: normal;
            font-size: 24px;
            line-height: 1;
            letter-spacing: normal;
            text-transform: none;
            display: inline-block;
            white-space: nowrap;
            word-wrap: normal;
            direction: ltr;
            -webkit-font-feature-settings: "liga";
            -webkit-font-smoothing: antialiased;
            font-variation-settings: "FILL" 1, "wght" 400, "GRAD" 0, "opsz" 24;
        }

        /* Hide scrollbar for clean look */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
@endsection

@section('content')
    <div class="flex h-screen w-full">
        @include('admin.includes.sidebar')

        <main class="flex-1 flex flex-col h-full overflow-hidden relative bg-background-light dark:bg-background-dark">
            @include('admin.includes.header')

            <div class="flex-1 overflow-y-auto p-6 lg:p-10 no-scrollbar">
                <div class="mx-auto max-w-7xl">

                    {{-- Alert Sukses --}}
                    @if (session('success'))
                        <div
                            class="mb-6 p-4 rounded-lg bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-400">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="mb-8 flex flex-col justify-between gap-4 md:flex-row md:items-start">
                        <div class="flex flex-col gap-1">
                            <div class="flex items-center gap-3">
                                <h1 class="text-3xl font-bold text-slate-900 dark:text-white tracking-tight">
                                    Laporan #{{ $report->report_code }}
                                </h1>

                                {{-- Status Badge Dinamis --}}
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
                            </div>
                            <p class="text-slate-500 dark:text-[#8e99cc]">
                                Ditinjau dari Petugas:
                                <span class="font-medium text-slate-900 dark:text-white">
                                    {{ $report->officer->name }} (ID: {{ $report->officer->nomor_induk }})
                                </span>
                            </p>
                        </div>

                        <div class="flex gap-2">
                            <div class="flex gap-2">
                                <a href="https://www.google.com/maps/search/?api=1&query={{ $report->station->latitude }},{{ $report->station->longitude }}"
                                    target="_blank"
                                    class="flex items-center gap-2 rounded-lg border border-gray-200 dark:border-[#1d293d] bg-white dark:bg-surface-dark px-4 py-2 text-sm font-medium text-slate-700 dark:text-white hover:bg-gray-50 dark:hover:bg-[#242a45] transition-colors shadow-sm">
                                    <span class="material-symbols-outlined text-red-500 text-[20px]">map</span>
                                    Lihat di Peta
                                </a>
                            </div>
                            <div class="flex gap-2">
                                <a href="{{ route('officer-reports.print', $report->id) }}" target="_blank"
                                    class="flex items-center gap-2 rounded-lg border border-gray-200 dark:border-[#1d293d] bg-white dark:bg-surface-dark px-4 py-2 text-sm font-medium text-slate-700 dark:text-white hover:bg-gray-50 dark:hover:bg-[#242a45] transition-colors">
                                    <span class="material-symbols-outlined text-sm">print</span>
                                    Cetak PDF
                                </a>
                            </div>
                        </div>

                    </div>

                    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
                        <div class="flex flex-col gap-6 lg:col-span-2">

                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                {{-- Card Ketinggian Air --}}
                                <div
                                    class="rounded-xl bg-white dark:bg-surface-dark border border-gray-200 dark:border-slate-800 p-5 shadow-sm">
                                    <div class="mb-2 flex items-center justify-between">
                                        <p class="text-sm font-medium text-slate-500 dark:text-[#8e99cc]">Ketinggian Air</p>
                                        <span class="material-symbols-outlined text-primary">water</span>
                                    </div>
                                    <p class="text-3xl font-bold text-slate-900 dark:text-white">
                                        {{ $report->water_level }} <span
                                            class="text-lg font-normal text-slate-500 dark:text-[#8e99cc]">cm</span>
                                    </p>
                                </div>

                                {{-- Card Status Bahaya --}}
                                <div
                                    class="rounded-xl bg-white dark:bg-surface-dark border border-gray-200 dark:border-slate-800 p-5 shadow-sm">
                                    <div class="mb-2 flex items-center justify-between">
                                        <p class="text-sm font-medium text-slate-500 dark:text-[#8e99cc]">Status Keadaan</p>
                                        <span class="material-symbols-outlined text-warning">warning</span>
                                    </div>
                                    <p
                                        class="text-3xl font-bold  {{ $report->calculated_status == 'awas' ? 'text-danger' : ($report->calculated_status == 'siaga' ? 'text-warning' : 'text-success') }}">
                                        {{ ucfirst($report->calculated_status) }}
                                    </p>
                                    <div class="mt-2 text-xs text-slate-500 dark:text-[#8e99cc]">
                                        Berdasarkan perhitungan sistem
                                    </div>
                                </div>
                            </div>

                            <div
                                class="rounded-xl bg-white dark:bg-surface-dark border border-gray-200 dark:border-slate-800 p-6 shadow-sm">
                                <h2 class="mb-4 text-lg font-semibold text-slate-900 dark:text-white">Detail Laporan</h2>
                                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                    <div class="space-y-4">
                                        <div
                                            class="flex flex-col gap-1 border-b border-gray-100 dark:border-[#1d293d] pb-3">
                                            <span
                                                class="text-xs font-medium uppercase text-slate-500 dark:text-[#8e99cc]">Lokasi
                                                Pos Pantau</span>
                                            <span class="text-base font-medium text-slate-900 dark:text-white">
                                                {{ $report->station->name }}
                                            </span>
                                        </div>
                                        <div
                                            class="flex flex-col gap-1 border-b border-gray-100 dark:border-[#1d293d] pb-3">
                                            <span
                                                class="text-xs font-medium uppercase text-slate-500 dark:text-[#8e99cc]">Waktu
                                                Laporan</span>
                                            <span class="text-base font-medium text-slate-900 dark:text-white">
                                                {{ $report->created_at->translatedFormat('d F Y, H:i') }} WIB
                                            </span>
                                        </div>
                                    </div>
                                    <div class="space-y-4">
                                        <div
                                            class="flex flex-col gap-1 border-b border-gray-100 dark:border-[#1d293d] pb-3">
                                            <span
                                                class="text-xs font-medium uppercase text-slate-500 dark:text-[#8e99cc]">Curah
                                                Hujan</span>
                                            <span class="text-base font-medium text-slate-900 dark:text-white">
                                                {{ $report->rainfall ?? '-' }} mm
                                            </span>
                                        </div>
                                        <div
                                            class="flex flex-col gap-1 border-b border-gray-100 dark:border-[#1d293d] pb-3">
                                            <span
                                                class="text-xs font-medium uppercase text-slate-500 dark:text-[#8e99cc]">Status
                                                Pompa</span>
                                            <span class="text-base font-medium text-slate-900 dark:text-white">
                                                {{ $report->pump_status ?? '-' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-4 pt-2">
                                    <span class="text-xs font-medium uppercase text-slate-500 dark:text-[#8e99cc]">Catatan
                                        Petugas</span>
                                    <p
                                        class="mt-2 text-sm leading-relaxed text-slate-700 dark:text-slate-300 bg-gray-50 dark:bg-[#1e2330] p-3 rounded-lg border border-gray-200 dark:border-[#1d293d]">
                                        {{ $report->note ?? 'Tidak ada catatan tambahan.' }}
                                    </p>
                                </div>
                            </div>

                            <div
                                class="rounded-xl border border-gray-200 dark:border-slate-800 bg-white dark:bg-surface-dark p-6 shadow-sm">
                                <h2 class="mb-4 text-lg font-semibold text-slate-900 dark:text-white">Bukti Foto</h2>
                                <div class="grid grid-cols-2 gap-4 md:grid-cols-3">
                                    {{-- Tampilkan Foto Asli dari Storage --}}
                                    @if ($report->photo)
                                        <div
                                            class="group relative aspect-square cursor-pointer overflow-hidden rounded-lg bg-gray-100 dark:bg-surface-dark border border-gray-200 dark:border-slate-800">
                                            <a href="{{ asset('storage/' . $report->photo) }}" target="_blank">
                                                <div class="h-full w-full bg-cover bg-center transition-transform duration-300 group-hover:scale-110"
                                                    style="background-image: url('{{ asset('storage/' . $report->photo) }}');">
                                                </div>
                                                <div
                                                    class="absolute inset-0 flex items-center justify-center bg-black/40 opacity-0 transition-opacity group-hover:opacity-100">
                                                    <span
                                                        class="material-symbols-outlined text-white text-3xl">visibility</span>
                                                </div>
                                            </a>
                                        </div>
                                    @else
                                        <p class="text-sm text-slate-500 italic col-span-3">Tidak ada foto terlampir.</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col gap-6 lg:col-span-1">

                            <div
                                class="sticky top-6 rounded-xl border border-gray-200 dark:border-slate-800 bg-white dark:bg-surface-dark p-6 shadow-lg">
                                <h3 class="mb-4 text-lg font-semibold text-slate-900 dark:text-white">
                                    Aksi Validasi
                                </h3>

                                {{-- FORM UPDATE START --}}
                                <form action="{{ route('officer-reports.update', $report->id) }}" method="POST"
                                    class="flex flex-col gap-4">
                                    @csrf
                                    @method('PUT')

                                    {{-- Input Feedback Admin --}}
                                    <div class="space-y-2">
                                        <label class="text-sm font-medium text-slate-500 dark:text-[#8e99cc]"
                                            for="feedback">
                                            Catatan Validasi (Admin)
                                        </label>
                                        <textarea name="admin_note"
                                            class="w-full rounded-lg border border-gray-300 dark:border-[#1d293d] bg-white dark:bg-surface-dark p-3 text-sm text-slate-900 dark:text-white placeholder-slate-400 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all resize-none"
                                            id="feedback" placeholder="Tulis alasan penolakan atau catatan tambahan..." rows="4">{{ $report->admin_note }}</textarea>
                                    </div>

                                    {{-- Tombol Aksi --}}
                                    @if ($report->validation_status == 'pending')
                                        <div class="mt-2 flex flex-col gap-3">
                                            {{-- Tombol Setujui --}}
                                            <button type="submit" name="validation_status" value="approved"
                                                class="group flex w-full items-center justify-center gap-2 rounded-lg bg-success py-3 px-4 text-sm font-semibold text-white shadow-md hover:brightness-110 transition-all">
                                                <span
                                                    class="material-symbols-outlined transition-transform group-hover:-translate-y-0.5">check_circle</span>
                                                Setujui Laporan
                                            </button>

                                            {{-- Tombol Tolak --}}
                                            <button type="submit" name="validation_status" value="rejected"
                                                class="group flex w-full items-center justify-center gap-2 rounded-lg border border-danger/30 bg-danger/10 py-2.5 px-3 text-sm font-medium text-danger hover:bg-danger/20 transition-all">
                                                <span class="material-symbols-outlined text-lg">cancel</span>
                                                Tolak
                                            </button>
                                        </div>
                                    @else
                                        <div
                                            class="mt-2 p-3 rounded bg-gray-100 dark:bg-slate-800 text-center text-sm text-slate-500">
                                            Laporan ini telah
                                            <strong>{{ $report->validation_status == 'approved' ? 'Disetujui' : 'Ditolak' }}</strong>
                                            <br>oleh Admin.
                                        </div>
                                    @endif
                                </form>
                                {{-- FORM UPDATE END --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
@endsection
