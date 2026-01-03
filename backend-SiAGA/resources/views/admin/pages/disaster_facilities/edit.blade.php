@extends('admin.layouts.app')

@section('breadcrumbs')
    <span class="material-symbols-outlined text-sm text-slate-500">chevron_right</span>
    <a class="text-sm font-medium text-slate-500 hover:text-primary dark:text-[#8e99cc]"
        href="{{ route('disaster-facilities.index') }}">Manajemen Fasilitas</a>
    <span class="material-symbols-outlined text-sm text-slate-500">chevron_right</span>
    <span class="text-sm font-medium text-slate-900 dark:text-white">Edit Fasilitas</span>
@endsection

@section('content')
    <div class="flex h-screen w-full overflow-hidden">
        @include('admin.includes.sidebar')

        <main class="flex-1 flex flex-col h-full overflow-hidden relative bg-background-light dark:bg-background-dark">
            @include('admin.includes.header')

            <div class="flex-1 overflow-y-auto p-6 md:p-10">
                <div class="mx-auto max-w-5xl">

                    <div class="mb-8 flex flex-col gap-2">
                        <h1 class="text-3xl md:text-4xl font-black text-gray-900 dark:text-white tracking-tight">
                            Edit Fasilitas Bencana
                        </h1>
                        <p class="text-base text-gray-500 dark:text-[#9ba0bb]">
                            Perbarui informasi fasilitas, status operasional, atau foto lokasi.
                        </p>
                    </div>

                    @if ($errors->any())
                        <div
                            class="mb-6 p-4 rounded-lg bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-400 flex items-start gap-3">
                            <span class="material-symbols-outlined text-xl mt-0.5">error</span>
                            <div>
                                <p class="font-bold mb-1">Terjadi Kesalahan Validasi:</p>
                                <ul class="list-disc list-inside text-sm">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('disaster-facilities.update', $facility->id) }}" method="POST"
                        enctype="multipart/form-data"
                        class="rounded-xl border border-gray-200 dark:border-[#2a2e3b] bg-white dark:bg-[#1b1d27] shadow-sm overflow-hidden">
                        @csrf
                        @method('PUT')

                        {{-- Pastikan partial ini adalah yang baru kita buat sebelumnya --}}
                        @include('admin.pages.disaster_facilities.partials.form')

                        <div
                            class="p-6 bg-gray-50 dark:bg-[#222530] border-t border-gray-200 dark:border-[#2a2e3b] flex items-center justify-end gap-3">
                            <a href="{{ route('disaster-facilities.index') }}"
                                class="px-6 py-2.5 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-[#2a2e3b] transition-colors"
                                type="button">
                                Batal
                            </a>
                            <button
                                class="px-6 py-2.5 rounded-lg text-sm font-medium text-white bg-primary hover:bg-blue-600 shadow-lg shadow-primary/30 transition-all flex items-center gap-2"
                                type="submit">
                                <span class="material-symbols-outlined text-[20px]">save</span>
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>

                <footer class="mt-12 mb-6 text-center">
                    <p class="text-sm text-gray-400 dark:text-gray-600">
                        © {{ date('Y') }} Sistem Monitoring Bencana. All rights reserved.
                    </p>
                </footer>
            </div>
        </main>
    </div>
@endsection
