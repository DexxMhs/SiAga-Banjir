@extends('admin.layouts.app')

@section('breadcrumbs')
    <span class="material-symbols-outlined text-sm text-slate-500">chevron_right</span>
    <a class="text-sm font-medium text-slate-500 hover:text-primary dark:text-[#8e99cc]"
        href="{{ route('public-reports.index') }}">Manajemen Laporan Masyarakat</a>
    <span class="material-symbols-outlined text-sm text-slate-500">chevron_right</span>
    <span class="text-sm font-medium text-slate-900 dark:text-white">Detail Laporan {{ $report->report_code }}</span>
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
                            class="mb-6 p-4 rounded-lg bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-400 flex items-center gap-2">
                            <span class="material-symbols-outlined text-xl">check_circle</span>
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- Header Section --}}
                    <div class="mb-8 flex flex-col justify-between gap-4 md:flex-row md:items-start">
                        <div class="flex flex-col gap-1">
                            <div class="flex items-center gap-3">
                                <h1 class="text-3xl font-bold text-slate-900 dark:text-white tracking-tight">
                                    Laporan #{{ $report->report_code }}
                                </h1>

                                {{-- Status Badge Dinamis --}}
                                @php
                                    $statusClass = match ($report->status) {
                                        'emergency'
                                            => 'bg-red-50 text-red-700 ring-red-600/20 dark:bg-red-900/20 dark:text-red-400 dark:ring-red-500/30',
                                        'selesai'
                                            => 'bg-green-50 text-green-700 ring-green-600/20 dark:bg-green-900/20 dark:text-green-400 dark:ring-green-500/30',
                                        'diproses'
                                            => 'bg-blue-50 text-blue-700 ring-blue-600/20 dark:bg-blue-900/20 dark:text-blue-400 dark:ring-blue-500/30',
                                        default
                                            => 'bg-gray-100 text-gray-600 ring-gray-500/10 dark:bg-gray-800 dark:text-gray-400 dark:ring-gray-700',
                                    };
                                    $statusLabel = match ($report->status) {
                                        'emergency' => 'DARURAT',
                                        'selesai' => 'Selesai',
                                        'diproses' => 'Sedang Diproses',
                                        default => 'Menunggu Verifikasi',
                                    };
                                @endphp
                                <span
                                    class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset {{ $statusClass }}">
                                    {{ $statusLabel }}
                                </span>
                            </div>

                            <p class="text-slate-500 dark:text-[#8e99cc]">
                                Dilaporkan Oleh:
                                <span class="font-medium text-slate-900 dark:text-white">
                                    {{ $report->user->name ?? 'User Tidak Dikenal' }}
                                </span>
                                <span class="mx-1">•</span>
                                {{ $report->created_at->translatedFormat('d F Y, H:i') }} WIB
                            </p>
                        </div>

                        <div class="flex gap-2">
                            <div class="flex gap-2">
                                <a href="https://www.google.com/maps/search/?api=1&query={{ $report->latitude }},{{ $report->longitude }}"
                                    target="_blank"
                                    class="flex items-center gap-2 rounded-lg border border-gray-200 dark:border-[#1d293d] bg-white dark:bg-surface-dark px-4 py-2 text-sm font-medium text-slate-700 dark:text-white hover:bg-gray-50 dark:hover:bg-[#242a45] transition-colors shadow-sm">
                                    <span class="material-symbols-outlined text-red-500 text-[20px]">map</span>
                                    Lihat di Peta
                                </a>
                            </div>
                            <div class="flex gap-2">
                                <a href="{{ route('public-reports.print', $report->id) }}" target="_blank"
                                    class="flex items-center gap-2 rounded-lg border border-gray-200 dark:border-[#1d293d] bg-white dark:bg-surface-dark px-4 py-2 text-sm font-medium text-slate-700 dark:text-white hover:bg-gray-50 dark:hover:bg-[#242a45] transition-colors">
                                    <span class="material-symbols-outlined text-sm">print</span>
                                    Cetak PDF
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

                        {{-- Kiri: Detail Data --}}
                        <div class="flex flex-col gap-6 lg:col-span-2">

                            {{-- Card Info Utama --}}
                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                {{-- Card Ketinggian Air --}}
                                <div
                                    class="rounded-xl bg-white dark:bg-surface-dark border border-gray-200 dark:border-slate-800 p-5 shadow-sm">
                                    <div class="mb-2 flex items-center justify-between">
                                        <p class="text-sm font-medium text-slate-500 dark:text-[#8e99cc]">Estimasi
                                            Ketinggian Air</p>
                                        <span class="material-symbols-outlined text-primary">water</span>
                                    </div>
                                    <p class="text-3xl font-bold text-slate-900 dark:text-white">
                                        {{ $report->water_level }} <span
                                            class="text-lg font-normal text-slate-500 dark:text-[#8e99cc]">cm</span>
                                    </p>
                                </div>

                                {{-- Card Koordinat --}}
                                <div
                                    class="rounded-xl bg-white dark:bg-surface-dark border border-gray-200 dark:border-slate-800 p-5 shadow-sm">
                                    <div class="mb-2 flex items-center justify-between">
                                        <p class="text-sm font-medium text-slate-500 dark:text-[#8e99cc]">Koordinat Lokasi
                                        </p>
                                        <span class="material-symbols-outlined text-gray-400">location_on</span>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-sm font-mono text-slate-900 dark:text-white">Lat:
                                            {{ number_format($report->latitude, 6) }}</span>
                                        <span class="text-sm font-mono text-slate-900 dark:text-white">Lng:
                                            {{ number_format($report->longitude, 6) }}</span>
                                    </div>
                                </div>
                            </div>

                            {{-- Card Detail Teks --}}
                            <div
                                class="rounded-xl bg-white dark:bg-surface-dark border border-gray-200 dark:border-slate-800 p-6 shadow-sm">
                                <h2 class="mb-4 text-lg font-semibold text-slate-900 dark:text-white">Informasi Laporan</h2>
                                <div class="space-y-6">

                                    {{-- Lokasi --}}
                                    <div class="border-b border-gray-100 dark:border-[#1d293d] pb-4">
                                        <span
                                            class="text-xs font-medium uppercase text-slate-500 dark:text-[#8e99cc] block mb-1">
                                            Lokasi Kejadian
                                        </span>
                                        <p class="text-base text-slate-900 dark:text-white leading-relaxed">
                                            {{ $report->location }}
                                        </p>
                                    </div>

                                    {{-- Catatan User --}}
                                    <div>
                                        <span
                                            class="text-xs font-medium uppercase text-slate-500 dark:text-[#8e99cc] block mb-2">
                                            Catatan Pelapor
                                        </span>
                                        <div
                                            class="bg-gray-50 dark:bg-[#1e2330] p-4 rounded-lg border border-gray-200 dark:border-[#1d293d]">
                                            <p class="text-sm text-slate-700 dark:text-slate-300 italic">
                                                "{{ $report->note ?? 'Tidak ada catatan tambahan.' }}"
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Card Bukti Foto --}}
                            <div
                                class="rounded-xl border border-gray-200 dark:border-slate-800 bg-white dark:bg-surface-dark p-6 shadow-sm">
                                <h2 class="mb-4 text-lg font-semibold text-slate-900 dark:text-white">Bukti Foto</h2>

                                @if ($report->photo)
                                    <div class="w-full max-w-md">
                                        <div
                                            class="group relative aspect-video cursor-pointer overflow-hidden rounded-lg bg-gray-100 dark:bg-surface-dark border border-gray-200 dark:border-slate-800">
                                            <a href="{{ asset('storage/' . $report->photo) }}" target="_blank">
                                                <img src="{{ asset('storage/' . $report->photo) }}" alt="Bukti Laporan"
                                                    class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105">
                                                <div
                                                    class="absolute inset-0 flex items-center justify-center bg-black/40 opacity-0 transition-opacity group-hover:opacity-100">
                                                    <div
                                                        class="bg-white/20 backdrop-blur-md px-4 py-2 rounded-full flex items-center gap-2 text-white">
                                                        <span class="material-symbols-outlined text-xl">zoom_in</span>
                                                        <span class="text-sm font-medium">Perbesar Foto</span>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                @else
                                    <div
                                        class="flex flex-col items-center justify-center py-8 px-4 border-2 border-dashed border-slate-200 dark:border-slate-700 rounded-lg">
                                        <span
                                            class="material-symbols-outlined text-4xl text-slate-300 dark:text-slate-600 mb-2">image_not_supported</span>
                                        <p class="text-sm text-slate-500 italic">Pelapor tidak menyertakan foto.</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- Kanan: Form Validasi Admin --}}
                        <div class="flex flex-col gap-6 lg:col-span-1">
                            <div
                                class="sticky top-6 rounded-xl border border-gray-200 dark:border-slate-800 bg-white dark:bg-surface-dark p-6 shadow-lg">
                                <h3
                                    class="mb-4 text-lg font-semibold text-slate-900 dark:text-white flex items-center gap-2">
                                    <span class="material-symbols-outlined text-primary">admin_panel_settings</span>
                                    Tindak Lanjut Admin
                                </h3>

                                <form action="{{ route('public-reports.update', $report->id) }}" method="POST"
                                    class="flex flex-col gap-5">
                                    @csrf
                                    @method('PUT')

                                    {{-- Info Validator Sebelumnya --}}
                                    @if ($report->validated_by)
                                        <div
                                            class="text-xs text-slate-500 bg-slate-50 dark:bg-slate-800 p-2 rounded border border-slate-100 dark:border-slate-700">
                                            Terakhir diperbarui oleh: <br>
                                            <span
                                                class="font-semibold text-slate-700 dark:text-slate-300">{{ $report->validator->name ?? 'Admin' }}</span>
                                        </div>
                                    @endif

                                    {{-- Dropdown Status --}}
                                    <div class="space-y-2">
                                        <label class="text-sm font-medium text-slate-700 dark:text-[#8e99cc]">Ubah Status
                                            Laporan</label>
                                        <div class="relative">
                                            <select name="status"
                                                class="w-full appearance-none rounded-lg border border-gray-300 dark:border-[#1d293d] bg-white dark:bg-surface-dark p-3 pr-10 text-sm text-slate-900 dark:text-white focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all cursor-pointer">
                                                <option value="pending"
                                                    {{ $report->status == 'pending' ? 'selected' : '' }}>Menunggu
                                                    Verifikasi</option>
                                                <option value="diproses"
                                                    {{ $report->status == 'diproses' ? 'selected' : '' }}>Sedang Diproses
                                                </option>
                                                <option value="selesai"
                                                    {{ $report->status == 'selesai' ? 'selected' : '' }}>Selesai / Teratasi
                                                </option>
                                                <option value="emergency"
                                                    {{ $report->status == 'emergency' ? 'selected' : '' }}>DARURAT
                                                    (Emergency)</option>
                                            </select>
                                            <div
                                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-slate-500">
                                                <span class="material-symbols-outlined text-[20px]">expand_more</span>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Textarea Feedback --}}
                                    <div class="space-y-2">
                                        <label class="text-sm font-medium text-slate-700 dark:text-[#8e99cc]"
                                            for="feedback">
                                            Catatan Admin
                                        </label>
                                        <textarea name="admin_note"
                                            class="w-full rounded-lg border border-gray-300 dark:border-[#1d293d] bg-white dark:bg-surface-dark p-3 text-sm text-slate-900 dark:text-white placeholder-slate-400 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all resize-none"
                                            id="feedback" placeholder="Contoh: Tim BPBD sudah meluncur ke lokasi..." rows="4">{{ $report->admin_note }}</textarea>
                                    </div>

                                    {{-- Button Submit --}}
                                    <button type="submit"
                                        class="group flex w-full items-center justify-center gap-2 rounded-lg bg-primary py-3 px-4 text-sm font-semibold text-white shadow-md hover:bg-primary/90 transition-all mt-2">
                                        <span class="material-symbols-outlined text-[20px]">save</span>
                                        Simpan Perubahan
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
@endsection
