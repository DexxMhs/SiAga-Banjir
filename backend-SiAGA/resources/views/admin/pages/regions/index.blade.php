@extends('admin.layouts.app')

@section('breadcrumbs')
    <span class="material-symbols-outlined text-sm text-slate-500">chevron_right</span>
    <span class="text-sm font-medium text-slate-900 dark:text-white">Manajemen Wilayah</span>
@endsection

@section('css')
    <style>
        body {
            font-family: "Public Sans", sans-serif;
        }

        .material-symbols-outlined {
            font-variation-settings: "FILL" 0, "wght" 400, "GRAD" 0, "opsz" 24;
        }

        /* Custom scrollbar */
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

            <main class="flex flex-1 flex-col overflow-hidden bg-background-light dark:bg-background-dark">
                @include('admin.includes.header')

                <div class="flex-1 overflow-y-auto p-6 md:p-8 lg:p-10">
                    <div class="mx-auto max-w-[1200px] flex flex-col gap-6">

                        <div class="flex flex-col gap-1">
                            <h1 class="font-display text-2xl font-bold text-slate-900 dark:text-white md:text-3xl">
                                Manajemen Wilayah
                            </h1>
                            <p class="text-slate-500 dark:text-[#8e99cc]">
                                Kelola data wilayah rawan banjir, status risiko, dan populasi terdampak.
                            </p>
                        </div>

                        <div
                            class="flex flex-col flex-wrap gap-4 rounded-xl bg-surface-light p-4 shadow-sm dark:bg-[#1a1f36] md:flex-row md:items-center md:justify-between">

                            <div class="flex flex-1 flex-col gap-3 md:flex-row md:items-center">
                                <form action="{{ route('regions.index') }}" method="GET"
                                    class="flex flex-col md:flex-row gap-3 w-full">

                                    <div class="relative w-full md:w-80">
                                        <span
                                            class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 dark:text-[#8e99cc]">search</span>
                                        <input name="search" value="{{ request('search') }}"
                                            class="h-10 w-full rounded-lg border-none bg-slate-100 pl-10 pr-4 text-sm font-medium text-slate-900 placeholder-slate-400 focus:ring-2 focus:ring-primary dark:bg-[#21284a] dark:text-white dark:placeholder-[#8e99cc]"
                                            placeholder="Cari nama wilayah atau lokasi..." type="text" />
                                    </div>

                                    <div class="relative min-w-[160px]">
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
                                            class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400 dark:text-[#8e99cc]">filter_list</span>
                                    </div>

                                    <button type="submit" class="hidden">Cari</button>
                                </form>
                            </div>

                            <div class="flex gap-3">
                                {{-- Tombol Export (Opsional) --}}
                                <a href="{{ route('regions.export', request()->query()) }}"
                                    class="flex h-10 items-center gap-2 rounded-lg bg-slate-100 px-4 text-sm font-bold text-slate-700 transition-colors hover:bg-slate-200 dark:bg-[#21284a] dark:text-white dark:hover:bg-[#2e365e]">
                                    <span class="material-symbols-outlined text-[20px]">file_download</span>
                                    <span class="hidden sm:inline">Export</span>
                                </a>

                                <a href="{{ route('regions.create') }}"
                                    class="flex h-10 items-center gap-2 rounded-lg bg-primary px-4 text-sm font-bold text-white shadow-lg shadow-primary/25 transition-all hover:bg-primary/90 hover:shadow-primary/40">
                                    <span class="material-symbols-outlined text-[20px]">add</span>
                                    <span>Tambah Wilayah</span>
                                </a>
                            </div>
                        </div>

                        <div
                            class="overflow-hidden rounded-xl border border-slate-200 bg-surface-light shadow-sm dark:border-[#21284a] dark:bg-[#1a1f36]">
                            <div class="overflow-x-auto">
                                <table class="w-full text-left text-sm">
                                    <thead
                                        class="border-b border-slate-200 bg-slate-50 text-xs font-semibold uppercase tracking-wider text-slate-500 dark:border-[#21284a] dark:bg-[#21284a] dark:text-[#8e99cc]">
                                        <tr>
                                            <th class="px-6 py-4">Nama Wilayah</th>
                                            <th class="px-6 py-4">Lokasi & Koordinat</th>
                                            <th class="px-6 py-4">Status Banjir</th>
                                            <th class="px-6 py-4">Populasi</th>
                                            <th class="px-6 py-4 text-right">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-200 dark:divide-[#21284a]">
                                        @forelse ($regions as $region)
                                            <tr
                                                class="group transition-colors hover:bg-slate-50 dark:hover:bg-[#21284a]/50">

                                                <td class="px-6 py-4">
                                                    <div class="flex items-center gap-3">
                                                        <div
                                                            class="flex size-10 items-center justify-center rounded-lg bg-indigo-100 dark:bg-indigo-500/10 overflow-hidden border border-slate-200 dark:border-slate-700">
                                                            @if ($region->photo)
                                                                <img src="{{ asset('storage/' . $region->photo) }}"
                                                                    alt="{{ $region->name }}"
                                                                    class="h-full w-full object-cover">
                                                            @else
                                                                <span
                                                                    class="material-symbols-outlined text-indigo-600 dark:text-indigo-400">location_city</span>
                                                            @endif
                                                        </div>
                                                        <div>
                                                            <p class="font-semibold text-slate-900 dark:text-white">
                                                                {{ $region->name }}
                                                            </p>
                                                            <p class="text-xs text-slate-500 dark:text-[#8e99cc]">
                                                                Diupdate: {{ $region->updated_at->diffForHumans() }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </td>

                                                <td class="px-6 py-4">
                                                    <div class="max-w-[200px]">
                                                        <p class="text-slate-700 dark:text-slate-300 truncate"
                                                            title="{{ $region->location }}">
                                                            {{ $region->location ?? '-' }}
                                                        </p>
                                                        @if ($region->latitude && $region->longitude)
                                                            <a href="https://www.google.com/maps/search/?api=1&query={{ $region->latitude }},{{ $region->longitude }}"
                                                                target="_blank"
                                                                class="mt-1 flex items-center gap-1 text-xs text-primary hover:underline">
                                                                <span
                                                                    class="material-symbols-outlined text-[14px]">map</span>
                                                                {{ number_format($region->latitude, 4) }},
                                                                {{ number_format($region->longitude, 4) }}
                                                            </a>
                                                        @else
                                                            <span class="text-xs text-slate-400 italic">Koordinat belum
                                                                diset</span>
                                                        @endif
                                                    </div>
                                                </td>

                                                <td class="px-6 py-4">
                                                    @php
                                                        $statusColor = match ($region->flood_status) {
                                                            'awas'
                                                                => 'bg-red-100 text-red-700 border-red-200 dark:bg-red-500/10 dark:text-red-400 dark:border-red-500/20',
                                                            'siaga'
                                                                => 'bg-amber-100 text-amber-700 border-amber-200 dark:bg-amber-500/10 dark:text-amber-400 dark:border-amber-500/20',
                                                            'normal'
                                                                => 'bg-emerald-100 text-emerald-700 border-emerald-200 dark:bg-emerald-500/10 dark:text-emerald-400 dark:border-emerald-500/20',
                                                            default
                                                                => 'bg-slate-100 text-slate-700 border-slate-200 dark:bg-slate-700/30 dark:text-slate-400',
                                                        };
                                                        $dotColor = match ($region->flood_status) {
                                                            'awas' => 'bg-red-500',
                                                            'siaga' => 'bg-amber-500',
                                                            'normal' => 'bg-emerald-500',
                                                            default => 'bg-slate-500',
                                                        };
                                                    @endphp
                                                    <span
                                                        class="inline-flex items-center gap-1.5 rounded-full border px-2.5 py-0.5 text-xs font-bold {{ $statusColor }}">
                                                        <span
                                                            class="size-1.5 rounded-full {{ $dotColor }} animate-pulse"></span>
                                                        {{ Str::ucfirst($region->flood_status) }}
                                                    </span>
                                                </td>

                                                <td class="px-6 py-4">
                                                    <div class="flex items-center gap-2">
                                                        <span
                                                            class="material-symbols-outlined text-slate-400 text-[18px]">group</span>
                                                        <span class="font-medium text-slate-700 dark:text-slate-300">
                                                            {{ $region->users_count ?? 0 }} Warga
                                                        </span>
                                                    </div>
                                                </td>

                                                <td class="px-6 py-4 text-right">
                                                    <div class="flex items-center justify-end gap-2">
                                                        <a href="{{ route('regions.edit', $region->id) }}"
                                                            class="rounded-lg p-2 text-slate-400 hover:bg-slate-100 hover:text-primary dark:hover:bg-[#2e365e] transition-colors"
                                                            title="Edit">
                                                            <span class="material-symbols-outlined text-[20px]">edit</span>
                                                        </a>

                                                        <button type="button" onclick="confirmDelete({{ $region->id }})"
                                                            class="rounded-lg p-2 text-slate-400 hover:bg-red-50 hover:text-red-500 dark:hover:bg-red-500/10 transition-colors"
                                                            title="Hapus">
                                                            <span
                                                                class="material-symbols-outlined text-[20px]">delete</span>
                                                        </button>

                                                        <form id="delete-form-{{ $region->id }}"
                                                            action="{{ route('regions.destroy', $region->id) }}"
                                                            method="POST" style="display: none;">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5"
                                                    class="px-6 py-12 text-center text-slate-500 dark:text-slate-400">
                                                    <div class="flex flex-col items-center gap-2">
                                                        <span
                                                            class="material-symbols-outlined text-4xl opacity-50">map</span>
                                                        <p>Belum ada data wilayah.</p>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <div
                                class="flex items-center justify-between border-t border-slate-200 px-6 py-4 dark:border-[#21284a]">
                                <p class="text-sm text-slate-500 dark:text-[#8e99cc]">
                                    Menampilkan
                                    <span
                                        class="font-semibold text-slate-900 dark:text-white">{{ $regions->firstItem() ?? 0 }}</span>
                                    sampai
                                    <span
                                        class="font-semibold text-slate-900 dark:text-white">{{ $regions->lastItem() ?? 0 }}</span>
                                    dari
                                    <span
                                        class="font-semibold text-slate-900 dark:text-white">{{ $regions->total() ?? 0 }}</span>
                                    data
                                </p>

                                <div class="flex gap-2">
                                    {{-- Previous Page Link --}}
                                    @if ($regions->onFirstPage())
                                        <span
                                            class="flex size-9 items-center justify-center rounded-lg border border-slate-200 bg-slate-50 text-slate-300 dark:border-[#2e365e] dark:bg-[#1a1f36] dark:text-slate-600 cursor-not-allowed">
                                            <span class="material-symbols-outlined text-sm">chevron_left</span>
                                        </span>
                                    @else
                                        <a href="{{ $regions->previousPageUrl() }}"
                                            class="flex size-9 items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-600 hover:bg-slate-50 dark:border-[#2e365e] dark:bg-[#21284a] dark:text-slate-400 dark:hover:bg-[#2e365e]">
                                            <span class="material-symbols-outlined text-sm">chevron_left</span>
                                        </a>
                                    @endif

                                    {{-- Next Page Link --}}
                                    @if ($regions->hasMorePages())
                                        <a href="{{ $regions->nextPageUrl() }}"
                                            class="flex size-9 items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-600 hover:bg-slate-50 dark:border-[#2e365e] dark:bg-[#21284a] dark:text-slate-400 dark:hover:bg-[#2e365e]">
                                            <span class="material-symbols-outlined text-sm">chevron_right</span>
                                        </a>
                                    @else
                                        <span
                                            class="flex size-9 items-center justify-center rounded-lg border border-slate-200 bg-slate-50 text-slate-300 dark:border-[#2e365e] dark:bg-[#1a1f36] dark:text-slate-600 cursor-not-allowed">
                                            <span class="material-symbols-outlined text-sm">chevron_right</span>
                                        </span>
                                    @endif
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
                    },
                },
            },
        };
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'Hapus Wilayah?',
                text: "Data wilayah dan relasinya akan dihapus permanen!",
                icon: 'warning',
                background: '#1a1f36',
                color: '#fff',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            })
        }
    </script>

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                background: '#1a1f36',
                color: '#fff',
                timer: 3000,
                showConfirmButton: false
            });
        </script>
    @endif
@endsection
