@extends('admin.layouts.app')

@section('breadcrumbs')
    <span class="material-symbols-outlined text-sm ...">chevron_right</span>
    <a class="text-sm font-medium text-slate-500 hover:text-primary dark:text-[#8e99cc]"
        href="{{ route('officers.index') }}">Manajemen Petugas</a>
    <span class="material-symbols-outlined text-sm ...">chevron_right</span>
    <span class="text-sm font-medium text-slate-900 dark:text-white">Tambah Petugas</span>
@endsection

@section('content')
    <div class="flex h-screen w-full overflow-hidden">
        <!-- Sidebar Navigation -->
        @include('admin.includes.sidebar')
        <!-- Main Content -->
        <main class="flex-1 flex flex-col h-full overflow-hidden relative">
            <!-- Top Navbar (User Profile) -->
            @include('admin.includes.header')
            <!-- Scrollable Content -->
            <div class="flex-1 overflow-y-auto p-6 md:p-10">
                <div class="mx-auto max-w-5xl">
                    <!-- Page Heading -->
                    <div class="mb-8 flex flex-col gap-2">
                        <h1 class="text-3xl md:text-4xl font-black text-gray-900 dark:text-white tracking-tight">
                            Tambah Petugas Baru
                        </h1>
                        <p class="text-base text-gray-500 dark:text-[#9ba0bb]">
                            Isi formulir di bawah untuk mendaftarkan petugas lapangan baru
                            ke dalam sistem.
                        </p>
                    </div>

                    @if ($errors->any())
                        <div
                            class="mb-6 p-4 rounded-lg bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-400">
                            <ul class="list-disc list-inside text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Form Card -->
                    <form action="{{ route('officers.store') }}" method="POST"
                        class="rounded-xl border border-gray-200 dark:border-[#2a2e3b] bg-white dark:bg-[#1b1d27] shadow-sm">
                        @csrf
                        @include('admin.pages.officers.partials.form')
                        <!-- Footer Actions -->
                        <div
                            class="p-6 bg-gray-50 dark:bg-[#222530] border-t border-gray-200 dark:border-[#2a2e3b] rounded-b-xl flex items-center justify-end gap-3">
                            <a href="{{ route('officers.index') }}"
                                class="px-6 py-2.5 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-[#2a2e3b] transition-colors"
                                type="button">
                                Batal
                            </a>
                            <button
                                class="px-6 py-2.5 rounded-lg text-sm font-medium text-white bg-primary hover:bg-blue-700 shadow-lg shadow-primary/30 transition-all flex items-center gap-2"
                                type="submit">
                                <span class="material-symbols-outlined text-[20px]">save</span>
                                Simpan Data
                            </button>
                        </div>
                    </form>
                </div>
                <!-- Footer -->
                <footer class="mt-12 mb-6 text-center">
                    <p class="text-sm text-gray-400 dark:text-gray-600">
                        © 2023 Sistem Monitoring Banjir. All rights reserved.
                    </p>
                </footer>
            </div>
        </main>
    </div>
@endsection
