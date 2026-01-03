@extends('admin.layouts.app')

@section('breadcrumbs')
    <span class="material-symbols-outlined text-sm ...">chevron_right</span>
    <span class="text-sm font-medium text-slate-900 dark:text-white">Manajemen Pos Pantau</span>
@endsection


@section('css')
    <style>
        body {
            font-family: "Public Sans", sans-serif;
        }

        .material-symbols-outlined {
            font-variation-settings: "FILL" 0, "wght" 400, "GRAD" 0, "opsz" 24;
        }

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
            background: #343e6b;
        }
    </style>
@endsection

@section('content')

    <body
        class="bg-background-light dark:bg-background-dark text-slate-900 dark:text-white antialiased selection:bg-primary/30">
        <div class="flex h-screen w-full overflow-hidden">
            @include('admin.includes.sidebar')
            <!-- Main Content Wrapper -->
            <main class="flex flex-1 flex-col overflow-hidden bg-background-light dark:bg-background-dark">
                <!-- Top Header -->
                @include('admin.includes.header')
                <!-- Scrollable Page Content -->
                <div class="flex-1 overflow-y-auto p-6 md:p-8 lg:p-10">
                    <div class="mx-auto max-w-[1200px] flex flex-col gap-6">
                        <!-- Page Title & Stats -->
                        <div class="flex flex-col gap-1">
                            <h1 class="font-display text-2xl font-bold text-slate-900 dark:text-white md:text-3xl">
                                Manajemen Pos Pantau
                            </h1>
                            <p class="text-slate-500 dark:text-[#8e99cc]">
                                Kelola data pos pantau, sensor air, dan status kewaspadaan.
                            </p>
                        </div>
                        <!-- Toolbar -->
                        <div
                            class="flex flex-col flex-wrap gap-4 rounded-xl bg-surface-light p-4 shadow-sm dark:bg-[#1a1f36] md:flex-row md:items-center md:justify-between">
                            <!-- Search & Filters -->
                            <div class="flex flex-1 flex-col gap-3 md:flex-row md:items-center">
                                <form action="{{ route('stations.index') }}" method="GET"
                                    class="flex flex-col md:flex-row gap-3 w-full">

                                    <div class="relative w-full md:w-80">
                                        <span
                                            class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 dark:text-[#8e99cc]">
                                            search
                                        </span>
                                        <input name="search" value="{{ request('search') }}"
                                            class="h-10 w-full rounded-lg border-none bg-slate-100 pl-10 pr-4 text-sm font-medium text-slate-900 placeholder-slate-400 focus:ring-2 focus:ring-primary dark:bg-[#21284a] dark:text-white dark:placeholder-[#8e99cc]"
                                            placeholder="Cari nama pos atau lokasi..." type="text" />
                                    </div>

                                    <div class="relative min-w-[140px]">
                                        <select name="status" onchange="this.form.submit()"
                                            class="h-10 w-full cursor-pointer appearance-none rounded-lg border-none bg-slate-100 px-4 pr-10 text-sm font-medium text-slate-700 focus:ring-2 focus:ring-primary dark:bg-[#21284a] dark:text-[#8e99cc]">
                                            <option value="">Semua Status</option>
                                            <option value="normal" {{ request('status') == 'normal' ? 'selected' : '' }}>
                                                Normal</option>
                                            <option value="siaga" {{ request('status') == 'siaga' ? 'selected' : '' }}>
                                                Siaga</option>
                                            <option value="awas" {{ request('status') == 'awas' ? 'selected' : '' }}>Awas
                                            </option>
                                        </select>
                                        <span
                                            class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400 dark:text-[#8e99cc]">
                                            filter_list
                                        </span>
                                    </div>

                                    <button type="submit" class="hidden">Cari</button>
                                </form>
                            </div>
                            <!-- Actions -->
                            <div class="flex gap-3">
                                <a href="{{ route('stations.export', request()->query()) }}"
                                    class="flex h-10 items-center gap-2 rounded-lg bg-slate-100 px-4 text-sm font-bold text-slate-700 transition-colors hover:bg-slate-200 dark:bg-[#21284a] dark:text-white dark:hover:bg-[#2e365e]">
                                    <span class="material-symbols-outlined text-[20px]">file_download</span>
                                    <span class="hidden sm:inline">Export</span>
                                </a>
                                <a href="{{ route('stations.create') }}"
                                    class="flex h-10 items-center gap-2 rounded-lg bg-primary px-4 text-sm font-bold text-white shadow-lg shadow-primary/25 transition-all hover:bg-primary/90 hover:shadow-primary/40">
                                    <span class="material-symbols-outlined text-[20px]">add</span>
                                    <span>Tambah Pos</span>
                                </a>
                            </div>
                        </div>
                        <!-- Data Table -->
                        <div
                            class="overflow-hidden rounded-xl border border-slate-200 bg-surface-light shadow-sm dark:border-[#21284a] dark:bg-[#1a1f36]">
                            <div class="overflow-x-auto">
                                <table class="w-full text-left text-sm">
                                    <thead
                                        class="border-b border-slate-200 bg-slate-50 text-xs font-semibold uppercase tracking-wider text-slate-500 dark:border-[#21284a] dark:bg-[#21284a] dark:text-[#8e99cc]">
                                        <tr>
                                            <th class="px-6 py-4">Nama Pos / ID</th>
                                            <th class="px-6 py-4">Lokasi</th>
                                            <th class="px-6 py-4">Tinggi Air</th>
                                            <th class="px-6 py-4">Status</th>
                                            <th class="px-6 py-4">Terakhir Update</th>
                                            <th class="px-6 py-4 text-right">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-200 dark:divide-[#21284a]">
                                        <!-- Row 1 -->
                                        @forelse ($stations as $index => $station)
                                            <tr
                                                class="group transition-colors hover:bg-slate-50 dark:hover:bg-[#21284a]/50">
                                                <td class="px-6 py-4">
                                                    <div class="flex items-center gap-3">
                                                        <div
                                                            class="flex size-10 items-center justify-center rounded-lg bg-blue-100 dark:bg-blue-500/10">
                                                            <span
                                                                class="material-symbols-outlined text-blue-600 dark:text-blue-400">sensors</span>
                                                        </div>
                                                        <div>
                                                            <p class="font-semibold text-slate-900 dark:text-white">
                                                                {{ $station->name }}
                                                            </p>
                                                            <p class="text-xs text-slate-500 dark:text-[#8e99cc]">
                                                                ID: {{ $station->station_code }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4">
                                                    <p class="text-slate-700 dark:text-slate-300">
                                                        {{ $station->location }}
                                                    </p>
                                                    <p class="text-xs text-slate-500 dark:text-[#8e99cc]">
                                                        {{ $station->latitude }}, {{ $station->longitude }}
                                                    </p>
                                                </td>
                                                <td class="px-6 py-4">
                                                    <span
                                                        class="font-bold text-slate-900 dark:text-white">{{ $station->water_level }}
                                                        cm</span>
                                                </td>

                                                @php
                                                    // Menghapus spasi dan mengubah ke huruf kecil agar pencocokan lebih akurat
                                                    $currentStatus = strtolower(trim($station->status));

                                                    $statusColor = match ($currentStatus) {
                                                        'awas'
                                                            => 'text-red-700 bg-red-100 dark:bg-red-500/15 dark:text-red-400',
                                                        'siaga'
                                                            => 'text-amber-700 bg-amber-100 dark:bg-amber-500/15 dark:text-amber-400',
                                                        'normal'
                                                            => 'text-emerald-700 bg-emerald-100 dark:bg-emerald-100/15 dark:text-emerald-400',
                                                        default
                                                            => 'text-slate-700 bg-slate-100 dark:bg-slate-500/15 dark:text-slate-400',
                                                    };

                                                    $dotColor = match ($currentStatus) {
                                                        'awas' => 'bg-red-500',
                                                        'siaga' => 'bg-amber-500',
                                                        'normal' => 'bg-emerald-500',
                                                        default => 'bg-slate-500',
                                                    };
                                                @endphp

                                                <td class="px-6 py-4">
                                                    <span
                                                        class="inline-flex items-center gap-1.5 rounded-full bg-emerald-100 px-2.5 py-1 text-xs font-bold {{ $statusColor }}">
                                                        <span class="size-1.5 rounded-full {{ $dotColor }}"></span>
                                                        {{ Str::ucfirst($station->status) }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4">
                                                    <p class="text-slate-700 dark:text-slate-300">
                                                        @if ($station->updated_at->diffInDays(now()) >= 1)
                                                            {{ floor($station->updated_at->diffInDays(now())) }} days ago
                                                        @else
                                                            {{ $station->updated_at->diffForHumans() }}
                                                        @endif
                                                    </p>
                                                </td>
                                                <td class="px-6 py-4 text-right">
                                                    <div class="flex items-center justify-end gap-2 transition-opacity">
                                                        <a href="{{ route('stations.edit', $station->id) }}"
                                                            class="rounded-lg p-2 text-slate-400 hover:bg-slate-100 hover:text-primary dark:hover:bg-[#2e365e]">
                                                            <span class="material-symbols-outlined text-[20px]">edit</span>
                                                        </a>
                                                        <button type="button" onclick="confirmDelete({{ $station->id }})"
                                                            class="p-2 text-slate-400 hover:text-red-400 hover:bg-red-500/10 rounded-lg transition-colors"
                                                            title="Hapus">
                                                            <span
                                                                class="material-symbols-outlined text-[20px]">delete</span>
                                                        </button>

                                                        {{-- Form Delete Tersembunyi --}}
                                                        <form id="delete-form-{{ $station->id }}"
                                                            action="{{ route('stations.destroy', $station->id) }}"
                                                            method="POST" style="display: none;">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
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
                                        class="font-semibold text-slate-900 dark:text-white">{{ $stations->firstItem() }}</span>
                                    sampai
                                    <span
                                        class="font-semibold text-slate-900 dark:text-white">{{ $stations->lastItem() }}</span>
                                    dari
                                    <span
                                        class="font-semibold text-slate-900 dark:text-white">{{ $stations->total() }}</span>
                                    hasil
                                </p>

                                <div class="flex gap-2">
                                    {{-- Tombol Sebelumnya --}}
                                    <a href="{{ $stations->previousPageUrl() }}"
                                        class="flex size-9 items-center justify-center rounded-lg border ... {{ $stations->onFirstPage() ? 'opacity-50 pointer-events-none' : '' }}">
                                        <span class="material-symbols-outlined text-sm">chevron_left</span>
                                    </a>

                                    {{-- Nomor Halaman --}}
                                    @foreach ($stations->getUrlRange(1, $stations->lastPage()) as $page => $url)
                                        <a href="{{ $url }}"
                                            class="flex size-9 items-center justify-center rounded-lg {{ $page == $stations->currentPage() ? 'bg-primary text-white' : 'border border-slate-200 bg-white text-slate-500' }}">
                                            {{ $page }}
                                        </a>
                                    @endforeach

                                    {{-- Tombol Selanjutnya --}}
                                    <a href="{{ $stations->nextPageUrl() }}"
                                        class="flex size-9 items-center justify-center rounded-lg border ... {{ !$stations->hasMorePages() ? 'opacity-50 pointer-events-none' : '' }}">
                                        <span class="material-symbols-outlined text-sm">chevron_right</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </body>
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
                        "surface-light": "#ffffff",
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

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Fungsi untuk konfirmasi hapus
        function confirmDelete(id) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data station ini akan dihapus permanen!",
                icon: 'warning',
                background: '#1a1f36', // Sesuaikan dengan warna surface-dark Anda
                color: '#fff',
                showCancelButton: true,
                confirmButtonColor: '#ef4444', // Warna Merah (Tailwind red-500)
                cancelButtonColor: '#6b7280', // Warna Abu (Tailwind gray-500)
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit form penghapusan
                    document.getElementById('delete-form-' + id).submit();
                }
            })
        }
    </script>
@endsection
