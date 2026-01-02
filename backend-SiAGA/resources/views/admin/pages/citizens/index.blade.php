@extends('admin.layouts.app')

@section('breadcrumbs')
    <span class="material-symbols-outlined text-sm ...">chevron_right</span>
    <span class="text-sm font-medium text-slate-900 dark:text-white">Manajemen Akun Masyarakat</span>
@endsection

@section('content')

    <body
        class="font-display bg-background-light dark:bg-background-dark text-slate-900 dark:text-white antialiased transition-colors duration-200">
        <div class="flex h-screen overflow-hidden">
            <!-- SideNavBar -->
            @include('admin.includes.sidebar')
            <!-- Main Content -->
            <main class="flex-1 flex flex-col min-w-0 overflow-hidden bg-background-light dark:bg-background-dark">
                <!-- TopNavBar -->
                @include('admin.includes.header')
                <!-- Page Content Scrollable Area -->
                <div class="flex-1 overflow-auto">
                    <div class="max-w-7xl mx-auto px-6 py-8">
                        <!-- PageHeading -->
                        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-8">
                            <div>
                                <h2 class="text-3xl font-black tracking-tight text-white mb-2">
                                    Manajemen Akun Masyarakat
                                </h2>
                                <p class="text-slate-400">
                                    Kelola data akun masyarakat di sistem.
                                </p>
                            </div>
                        </div>
                        <!-- Filters and Search -->
                        <form action="{{ route('citizens.index') }}" method="GET"
                            class="bg-surface-dark border border-slate-800 rounded-t-xl p-4 flex flex-col md:flex-row gap-4 items-center justify-between">

                            <!-- SearchBar -->
                            <div class="relative w-full md:w-96 group">
                                <span
                                    class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-500 group-focus-within:text-primary transition-colors">search</span>
                                <input name="search" value="{{ request('search') }}"
                                    class="w-full bg-background-dark border border-slate-700 text-white text-sm rounded-lg focus:ring-primary focus:border-primary block pl-10 p-2.5 placeholder-slate-500 transition-all"
                                    placeholder="Cari nama, ID, atau no. telepon..." type="text" />
                            </div>
                            <button type="submit" class="hidden">Cari</button>
                        </form>
                        <!-- Data Table -->
                        <div
                            class="bg-surface-dark border border-slate-800 border-t-0 rounded-b-xl overflow-hidden shadow-sm">
                            <div class="overflow-x-auto">
                                <table class="w-full text-sm text-left text-slate-400">
                                    <thead
                                        class="text-xs text-slate-400 uppercase bg-surface-dark-lighter border-b border-slate-700">
                                        <tr>
                                            <th class="px-6 py-4 font-semibold" scope="col">
                                                Petugas
                                            </th>
                                            <th class="px-6 py-4 font-semibold" scope="col">
                                                Email
                                            </th>
                                            <th class="px-6 py-4 font-semibold" scope="col">
                                                Wilayah Tinggal
                                            </th>
                                            <th class="px-6 py-4 font-semibold text-right" scope="col">
                                                Aksi
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-800">
                                        <!-- Row 1 -->
                                        @forelse ($citizens as $index => $citizen)
                                            <tr class="bg-surface-dark hover:bg-slate-800/50 transition-colors">
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="flex items-center gap-4">
                                                        {{-- LOGIKA FOTO PROFIL --}}
                                                        @if ($citizen->photo)
                                                            {{-- TAMPILKAN FOTO JIKA ADA --}}
                                                            <img src="{{ asset('storage/' . $citizen->photo) }}"
                                                                alt="{{ $citizen->name }}"
                                                                class="h-10 w-10 rounded-full object-cover border border-slate-600 shrink-0">
                                                        @else
                                                            {{-- TAMPILKAN INISIAL JIKA FOTO KOSONG (Fallback) --}}
                                                            <div
                                                                class="h-10 w-10 rounded-full bg-primary/20 flex items-center justify-center text-primary font-bold text-lg shrink-0">
                                                                {{ strtoupper(substr($citizen->name, 0, 2)) }}
                                                            </div>
                                                        @endif
                                                        <div>
                                                            <div class="text-base font-medium text-white">
                                                                {{ $citizen->name }}
                                                            </div>
                                                            <div class="text-xs text-slate-500">
                                                                ID: {{ $citizen->id }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-xs text-slate-500">
                                                        {{ $citizen->email }}
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    {{ $citizen->region->name }}
                                                </td>
                                                <td class="px-6 py-4 text-right whitespace-nowrap">
                                                    <div class="flex items-center justify-end gap-2">
                                                        <a href="{{ route('citizens.edit', $citizen->id) }}"
                                                            class="p-2 text-slate-400 hover:text-white hover:bg-white/10 rounded-lg transition-colors"
                                                            title="Edit">
                                                            <span class="material-symbols-outlined text-[20px]">edit</span>
                                                        </a>

                                                        {{-- Tombol Delete dengan OnClick --}}
                                                        <button type="button" onclick="confirmDelete({{ $citizen->id }})"
                                                            class="p-2 text-slate-400 hover:text-red-400 hover:bg-red-500/10 rounded-lg transition-colors"
                                                            title="Hapus">
                                                            <span
                                                                class="material-symbols-outlined text-[20px]">delete</span>
                                                        </button>

                                                        {{-- Form Delete Tersembunyi --}}
                                                        <form id="delete-form-{{ $citizen->id }}"
                                                            action="{{ route('citizens.destroy', $citizen->id) }}"
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
                                        class="font-semibold text-slate-900 dark:text-white">{{ $citizens->firstItem() }}</span>
                                    sampai
                                    <span
                                        class="font-semibold text-slate-900 dark:text-white">{{ $citizens->lastItem() }}</span>
                                    dari
                                    <span
                                        class="font-semibold text-slate-900 dark:text-white">{{ $citizens->total() }}</span>
                                    hasil
                                </p>

                                <div class="flex gap-2">
                                    {{-- Tombol Sebelumnya --}}
                                    <a href="{{ $citizens->previousPageUrl() }}"
                                        class="flex size-9 items-center justify-center rounded-lg border ... {{ $citizens->onFirstPage() ? 'opacity-50 pointer-events-none' : '' }}">
                                        <span class="material-symbols-outlined text-sm">chevron_left</span>
                                    </a>

                                    {{-- Nomor Halaman --}}
                                    @foreach ($citizens->getUrlRange(1, $citizens->lastPage()) as $page => $url)
                                        <a href="{{ $url }}"
                                            class="flex size-9 items-center justify-center rounded-lg {{ $page == $citizens->currentPage() ? 'bg-primary text-white' : 'border border-slate-200 bg-white text-slate-500' }}">
                                            {{ $page }}
                                        </a>
                                    @endforeach

                                    {{-- Tombol Selanjutnya --}}
                                    <a href="{{ $citizens->nextPageUrl() }}"
                                        class="flex size-9 items-center justify-center rounded-lg border ... {{ !$citizens->hasMorePages() ? 'opacity-50 pointer-events-none' : '' }}">
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

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Fungsi untuk konfirmasi hapus
        function confirmDelete(id) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data warga ini akan dihapus permanen!",
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
