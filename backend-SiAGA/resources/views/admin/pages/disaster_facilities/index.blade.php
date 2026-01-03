@extends('admin.layouts.app')

@section('breadcrumbs')
    <span class="material-symbols-outlined text-sm text-slate-500">chevron_right</span>
    <span class="text-sm font-medium text-slate-900 dark:text-white">Manajemen Fasilitas Bencana</span>
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

            <main class="flex flex-1 flex-col overflow-hidden bg-background-light dark:bg-background-dark">
                @include('admin.includes.header')

                <div class="flex-1 overflow-y-auto p-6 md:p-8 lg:p-10">
                    <div class="mx-auto max-w-[1200px] flex flex-col gap-6">

                        <div class="flex flex-col gap-1">
                            <h1 class="font-display text-2xl font-bold text-slate-900 dark:text-white md:text-3xl">
                                Fasilitas Bencana
                            </h1>
                            <p class="text-slate-500 dark:text-[#8e99cc]">
                                Kelola data posko pengungsian, dapur umum, dan fasilitas kesehatan.
                            </p>
                        </div>

                        <div
                            class="flex flex-col flex-wrap gap-4 rounded-xl bg-surface-light p-4 shadow-sm dark:bg-[#1a1f36] md:flex-row md:items-center md:justify-between">

                            <div class="flex flex-1 flex-col gap-3 md:flex-row md:items-center w-full">
                                <form action="{{ route('disaster-facilities.index') }}" method="GET"
                                    class="flex flex-col md:flex-row gap-3 w-full">

                                    <div class="relative w-full md:w-80">
                                        <span
                                            class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 dark:text-[#8e99cc]">search</span>
                                        <input name="search" value="{{ request('search') }}"
                                            class="h-10 w-full rounded-lg border-none bg-slate-100 pl-10 pr-4 text-sm font-medium text-slate-900 placeholder-slate-400 focus:ring-2 focus:ring-primary dark:bg-[#21284a] dark:text-white dark:placeholder-[#8e99cc]"
                                            placeholder="Cari nama, kode, atau alamat..." type="text" />
                                    </div>

                                    <div class="relative w-full md:w-48">
                                        <select name="type" onchange="this.form.submit()"
                                            class="h-10 w-full appearance-none rounded-lg border-none bg-slate-100 px-4 text-sm font-medium text-slate-700 focus:ring-2 focus:ring-primary dark:bg-[#21284a] dark:text-white cursor-pointer">
                                            <option value="">Semua Tipe</option>
                                            <option value="pengungsian"
                                                {{ request('type') == 'pengungsian' ? 'selected' : '' }}>Pengungsian
                                            </option>
                                            <option value="dapur_umum"
                                                {{ request('type') == 'dapur_umum' ? 'selected' : '' }}>Dapur Umum</option>
                                            <option value="posko_kesehatan"
                                                {{ request('type') == 'posko_kesehatan' ? 'selected' : '' }}>Posko Kesehatan
                                            </option>
                                            <option value="logistik" {{ request('type') == 'logistik' ? 'selected' : '' }}>
                                                Logistik</option>
                                        </select>
                                        <span
                                            class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">expand_more</span>
                                    </div>

                                    <button type="submit" class="hidden">Cari</button>
                                </form>
                            </div>

                            <div class="flex gap-3">
                                {{-- Tombol Export (Opsional jika controller belum ada export, bisa di-comment dulu) --}}
                                {{-- <a href="{{ route('admin.disaster-facilities.export', request()->query()) }}" --}}
                                <a href="#" onclick="alert('Fitur export belum tersedia')"
                                    class="flex h-10 items-center gap-2 rounded-lg bg-slate-100 px-4 text-sm font-bold text-slate-700 transition-colors hover:bg-slate-200 dark:bg-[#21284a] dark:text-white dark:hover:bg-[#2e365e]">
                                    <span class="material-symbols-outlined text-[20px]">file_download</span>
                                    <span class="hidden sm:inline">Export</span>
                                </a>

                                <a href="{{ route('disaster-facilities.create') }}"
                                    class="flex h-10 items-center gap-2 rounded-lg bg-primary px-4 text-sm font-bold text-white shadow-lg shadow-primary/25 transition-all hover:bg-primary/90 hover:shadow-primary/40">
                                    <span class="material-symbols-outlined text-[20px]">add</span>
                                    <span>Tambah Fasilitas</span>
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
                                            <th class="px-6 py-4">Fasilitas / Kode</th>
                                            <th class="px-6 py-4">Tipe & Status</th>
                                            <th class="px-6 py-4">Alamat & Koordinat</th>
                                            <th class="px-6 py-4">Update Terakhir</th>
                                            <th class="px-6 py-4 text-right">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-200 dark:divide-[#21284a]">
                                        @forelse ($facilities as $facility)
                                            <tr
                                                class="group transition-colors hover:bg-slate-50 dark:hover:bg-[#21284a]/50">

                                                <td class="px-6 py-4">
                                                    <div class="flex items-center gap-3">
                                                        <div
                                                            class="flex size-12 items-center justify-center rounded-lg bg-blue-100 dark:bg-blue-500/10 overflow-hidden border border-slate-200 dark:border-slate-700">
                                                            @if ($facility->photo_path)
                                                                <img src="{{ asset('storage/' . $facility->photo_path) }}"
                                                                    alt="{{ $facility->name }}"
                                                                    class="h-full w-full object-cover">
                                                            @else
                                                                <span
                                                                    class="material-symbols-outlined text-blue-600 dark:text-blue-400">domain</span>
                                                            @endif
                                                        </div>
                                                        <div>
                                                            <p
                                                                class="font-bold text-slate-900 dark:text-white line-clamp-1">
                                                                {{ $facility->name }}
                                                            </p>
                                                            <span
                                                                class="inline-flex items-center rounded-md bg-slate-100 px-2 py-0.5 text-xs font-medium text-slate-600 ring-1 ring-inset ring-slate-500/10 dark:bg-slate-400/10 dark:text-slate-400 dark:ring-slate-400/20">
                                                                {{ $facility->unique_code }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </td>

                                                <td class="px-6 py-4">
                                                    <div class="flex flex-col gap-2">
                                                        <span class="font-medium text-slate-700 dark:text-slate-300">
                                                            {{ ucwords(str_replace('_', ' ', $facility->type)) }}
                                                        </span>

                                                        @php
                                                            $statusColor = match ($facility->status) {
                                                                'buka'
                                                                    => 'bg-green-100 text-green-700 border-green-200 dark:bg-green-500/10 dark:text-green-400 dark:border-green-500/20',
                                                                'penuh'
                                                                    => 'bg-orange-100 text-orange-700 border-orange-200 dark:bg-orange-500/10 dark:text-orange-400 dark:border-orange-500/20',
                                                                'tutup'
                                                                    => 'bg-slate-100 text-slate-700 border-slate-200 dark:bg-slate-700/30 dark:text-slate-400 dark:border-slate-600',
                                                            };
                                                        @endphp
                                                        <span
                                                            class="inline-flex w-fit items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold {{ $statusColor }}">
                                                            {{ strtoupper($facility->status) }}
                                                        </span>
                                                    </div>
                                                </td>

                                                <td class="px-6 py-4">
                                                    <div class="max-w-[200px]">
                                                        <p class="text-sm text-slate-700 dark:text-slate-300 line-clamp-2"
                                                            title="{{ $facility->address }}">
                                                            {{ $facility->address }}
                                                        </p>
                                                        <a href="https://www.google.com/maps/search/?api=1&query={{ $facility->latitude }},{{ $facility->longitude }}"
                                                            target="_blank"
                                                            class="mt-1 flex items-center gap-1 text-xs text-primary hover:underline">
                                                            <span
                                                                class="material-symbols-outlined text-[14px]">location_on</span>
                                                            Lihat di Peta
                                                        </a>
                                                    </div>
                                                </td>

                                                <td class="px-6 py-4">
                                                    <p class="text-sm text-slate-500 dark:text-[#8e99cc]">
                                                        {{ $facility->updated_at->translatedFormat('d M Y') }}
                                                    </p>
                                                    <p class="text-xs text-slate-400 dark:text-slate-600">
                                                        {{ $facility->updated_at->format('H:i') }} WIB
                                                    </p>
                                                </td>

                                                <td class="px-6 py-4 text-right">
                                                    <div class="flex items-center justify-end gap-2">
                                                        <a href="{{ route('disaster-facilities.edit', $facility->id) }}"
                                                            class="rounded-lg p-2 text-slate-400 hover:bg-slate-100 hover:text-primary dark:hover:bg-[#2e365e] transition-colors"
                                                            title="Edit">
                                                            <span class="material-symbols-outlined text-[20px]">edit</span>
                                                        </a>

                                                        <button type="button" onclick="confirmDelete({{ $facility->id }})"
                                                            class="rounded-lg p-2 text-slate-400 hover:bg-red-50 hover:text-red-500 dark:hover:bg-red-500/10 transition-colors"
                                                            title="Hapus">
                                                            <span
                                                                class="material-symbols-outlined text-[20px]">delete</span>
                                                        </button>

                                                        <form id="delete-form-{{ $facility->id }}"
                                                            action="{{ route('disaster-facilities.destroy', $facility->id) }}"
                                                            method="POST" style="display: none;">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="px-6 py-12 text-center">
                                                    <div
                                                        class="flex flex-col items-center justify-center gap-2 text-slate-400 dark:text-slate-600">
                                                        <span
                                                            class="material-symbols-outlined text-4xl">domain_disabled</span>
                                                        <p>Belum ada data fasilitas bencana.</p>
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
                                        class="font-semibold text-slate-900 dark:text-white">{{ $facilities->firstItem() ?? 0 }}</span>
                                    sampai
                                    <span
                                        class="font-semibold text-slate-900 dark:text-white">{{ $facilities->lastItem() ?? 0 }}</span>
                                    dari
                                    <span
                                        class="font-semibold text-slate-900 dark:text-white">{{ $facilities->total() ?? 0 }}</span>
                                    data
                                </p>

                                <div class="flex gap-2">
                                    {{-- Menggunakan simple pagination manual jika ingin gaya custom --}}
                                    @if ($facilities->onFirstPage())
                                        <span
                                            class="flex size-9 items-center justify-center rounded-lg border border-slate-200 bg-slate-50 text-slate-300 dark:border-[#2e365e] dark:bg-[#1a1f36] dark:text-slate-600 cursor-not-allowed">
                                            <span class="material-symbols-outlined text-sm">chevron_left</span>
                                        </span>
                                    @else
                                        <a href="{{ $facilities->previousPageUrl() }}"
                                            class="flex size-9 items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-600 hover:bg-slate-50 dark:border-[#2e365e] dark:bg-[#21284a] dark:text-slate-400 dark:hover:bg-[#2e365e]">
                                            <span class="material-symbols-outlined text-sm">chevron_left</span>
                                        </a>
                                    @endif

                                    @if ($facilities->hasMorePages())
                                        <a href="{{ $facilities->nextPageUrl() }}"
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
                title: 'Hapus Fasilitas?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
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

    {{-- Notifikasi Sukses dari Controller --}}
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
