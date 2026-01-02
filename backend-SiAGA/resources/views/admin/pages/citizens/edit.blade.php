@extends('admin.layouts.app')

@section('breadcrumbs')
    <span class="material-symbols-outlined text-sm ...">chevron_right</span>
    <a class="text-sm font-medium text-slate-500 hover:text-primary dark:text-[#8e99cc]"
        href="{{ route('citizens.index') }}">Manajemen Petugas</a>
    <span class="material-symbols-outlined text-sm ...">chevron_right</span>
    <span class="text-sm font-medium text-slate-900 dark:text-white">Edit Petugas</span>
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
                            Edit Data Petugas
                        </h1>
                        <p class="text-base text-gray-500 dark:text-[#9ba0bb]">
                            Perbarui informasi, kontak, dan wilayah tugas petugas lapangan.
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
                    <form action="{{ route('citizens.update', $citizen->id) }}" method="POST" enctype="multipart/form-data"
                        class="rounded-xl border border-gray-200 dark:border-[#2a2e3b] bg-white dark:bg-[#1b1d27] shadow-sm">
                        @csrf
                        @method('PUT')
                        <!-- Section: Profile Photo -->
                        <div class="rounded-xl border border-slate-800 bg-surface-dark p-6">
                            <h3 class="text-white text-lg font-bold mb-6 flex items-center gap-2">
                                <span class="material-symbols-outlined text-primary">badge</span>
                                Foto Profil
                            </h3>

                            <div class="flex flex-col md:flex-row gap-6 items-center md:items-start">
                                <div class="relative group">
                                    <div id="imagePreview"
                                        class="size-32 rounded-full bg-cover bg-center border-4 border-[#272a3a] transition-all duration-300"
                                        style="background-image: url('{{ $citizen->photo ? asset('storage/' . $citizen->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($citizen->name) . '&color=7F9CF5&background=EBF4FF' }}');">
                                    </div>

                                    <button type="button" onclick="document.getElementById('photoInput').click()"
                                        class="absolute bottom-0 right-0 bg-primary text-white p-2 rounded-full shadow-lg hover:bg-blue-600 transition-colors z-10">
                                        <span class="material-symbols-outlined text-sm">edit</span>
                                    </button>
                                </div>

                                <div class="flex flex-col justify-center gap-2">
                                    <p class="text-white font-medium text-lg">{{ $citizen->name }}</p>
                                    <p class="text-[#9ba0bb] text-sm">
                                        Diperbolehkan JPG, GIF atau PNG. Ukuran maksimal 800KB.
                                    </p>

                                    <div class="flex gap-3 mt-2">
                                        <button type="button" onclick="deletePhoto()"
                                            class="px-4 py-2 bg-input-bg hover:bg-[#323648] text-white text-sm font-medium rounded-lg transition-colors border border-slate-700">
                                            Hapus Foto
                                        </button>

                                        <button type="button" onclick="document.getElementById('photoInput').click()"
                                            class="px-4 py-2 bg-primary/20 text-primary hover:bg-primary/30 text-sm font-medium rounded-lg transition-colors border border-primary/20">
                                            Unggah Baru
                                        </button>
                                    </div>

                                    <input type="file" id="photoInput" name="photo" class="hidden" accept="image/*"
                                        onchange="previewImage(this)">

                                    <input type="hidden" id="deletePhotoFlag" name="delete_photo_flag" value="0">
                                </div>
                            </div>
                        </div>

                        @include('admin.pages.citizens.partials.form')

                        <!-- Footer Actions -->
                        <div
                            class="p-6 bg-gray-50 dark:bg-[#222530] border-t border-gray-200 dark:border-[#2a2e3b] rounded-b-xl flex items-center justify-end gap-3">
                            <a href="{{ route('citizens.index') }}"
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

@section('script')
    <script>
        function previewImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    // Ganti background image div preview
                    document.getElementById('imagePreview').style.backgroundImage = 'url(' + e.target.result + ')';
                    // Reset flag hapus jika user upload foto baru
                    document.getElementById('deletePhotoFlag').value = '0';
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        function deletePhoto() {
            // Reset input file
            document.getElementById('photoInput').value = '';

            // Set preview ke default avatar
            const defaultAvatar =
                'https://ui-avatars.com/api/?name={{ urlencode($citizen->name) }}&color=7F9CF5&background=EBF4FF';
            document.getElementById('imagePreview').style.backgroundImage = 'url(' + defaultAvatar + ')';

            // Set flag hapus ke true (1) agar controller menghapus file di DB
            document.getElementById('deletePhotoFlag').value = '1';
        }
    </script>
@endsection
