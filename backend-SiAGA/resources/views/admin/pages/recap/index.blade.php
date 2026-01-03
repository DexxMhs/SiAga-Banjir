@extends('admin.layouts.app')

@section('breadcrumbs')
    <span class="material-symbols-outlined text-sm text-slate-500">chevron_right</span>
    <span class="text-sm font-medium text-slate-900 dark:text-white">Rekap Laporan</span>
@endsection

@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/dark.css">
    <style>
        /* Hide scrollbar logic */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #0f1323;
        }

        ::-webkit-scrollbar-thumb {
            background: #33394f;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #474f6b;
        }

        [x-cloak] {
            display: none !important;
        }
    </style>
@endsection

@section('content')
    <div class="flex h-screen w-full overflow-hidden">
        @include('admin.includes.sidebar')

        <main class="flex-1 flex flex-col h-full overflow-hidden relative bg-background-light dark:bg-background-dark">
            @include('admin.includes.header')

            <div class="flex-1 overflow-y-auto p-4 md:p-8">
                <div class="max-w-[1200px] mx-auto space-y-8 pb-10">

                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                        <div class="space-y-1">
                            <h1 class="text-3xl font-bold text-slate-900 dark:text-white tracking-tight">
                                Rekapitulasi Data
                            </h1>
                            <p class="text-slate-500 dark:text-[#9ba0bb]">
                                Data gabungan dari laporan masyarakat dan pemantauan petugas lapangan.
                            </p>
                        </div>
                        <div class="flex gap-3">
                            <a href="{{ route('recap.print', request()->query()) }}" target="_blank"
                                class="bg-white dark:bg-[#1a1f33] border border-slate-200 dark:border-white/10 text-slate-700 dark:text-white px-4 py-2.5 rounded-lg text-sm font-medium hover:bg-slate-50 dark:hover:bg-[#252b42] flex items-center gap-2 transition-colors">
                                <span class="material-symbols-outlined text-[20px]">print</span>
                                Cetak PDF
                            </a>
                        </div>
                    </div>

                    <form action="{{ route('recap.index') }}" method="GET"
                        class="bg-white dark:bg-[#1a1f33] rounded-xl border border-slate-200 dark:border-white/5 p-5 shadow-sm">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">

                            <div class="md:col-span-1">
                                <label class="block text-slate-500 dark:text-[#9ba0bb] text-sm font-medium mb-2">Periode
                                    Waktu</label>
                                <div class="relative">
                                    <input id="date-range"
                                        class="w-full bg-slate-50 dark:bg-[#0f1323] border border-slate-200 dark:border-white/10 text-slate-900 dark:text-white text-sm rounded-lg focus:ring-primary focus:border-primary block p-2.5 pl-10 h-11 placeholder-slate-400"
                                        placeholder="Pilih tanggal..." type="text"
                                        value="{{ request('start_date') && request('end_date') ? request('start_date') . ' to ' . request('end_date') : '' }}" />
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="material-symbols-outlined text-slate-400 text-[20px]">date_range</span>
                                    </div>
                                    <input type="hidden" name="start_date" id="start_date"
                                        value="{{ request('start_date') }}">
                                    <input type="hidden" name="end_date" id="end_date" value="{{ request('end_date') }}">
                                </div>
                            </div>

                            <div class="md:col-span-1">
                                <label
                                    class="block text-slate-500 dark:text-[#9ba0bb] text-sm font-medium mb-2">Cari</label>
                                <div class="relative">
                                    <input name="search" value="{{ request('search') }}"
                                        class="w-full bg-slate-50 dark:bg-[#0f1323] border border-slate-200 dark:border-white/10 text-slate-900 dark:text-white text-sm rounded-lg focus:ring-primary focus:border-primary block p-2.5 pl-10 h-11 placeholder-slate-400"
                                        placeholder="ID / Lokasi..." type="text" />
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="material-symbols-outlined text-slate-400 text-[20px]">search</span>
                                    </div>
                                </div>
                            </div>

                            <div class="md:col-span-1 flex gap-2">

                                {{-- Tombol Reset --}}
                                <a href="{{ route('recap.index') }}"
                                    class="w-12 bg-slate-100 dark:bg-white/5 border border-slate-200 dark:border-white/10 text-slate-600 dark:text-slate-400 hover:text-red-500 hover:border-red-500/30 dark:hover:text-red-400 font-medium rounded-lg text-sm transition-all h-11 flex justify-center items-center"
                                    title="Reset Filter">
                                    <span class="material-symbols-outlined text-[20px]">restart_alt</span>
                                </a>

                                {{-- Tombol Submit --}}
                                <button type="submit"
                                    class="flex-1 bg-primary text-white font-medium rounded-lg text-sm px-4 py-2.5 text-center transition-all h-11 flex justify-center items-center gap-2 hover:bg-blue-600 shadow-lg shadow-primary/20">
                                    <span class="material-symbols-outlined text-[20px]">filter_list</span>
                                    Terapkan
                                </button>
                            </div>

                        </div>
                    </form>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div
                            class="bg-white dark:bg-[#1a1f33] p-5 rounded-xl border border-slate-200 dark:border-white/5 relative overflow-hidden group shadow-sm">
                            <div class="absolute top-0 right-0 p-4 opacity-10"><span
                                    class="material-symbols-outlined text-6xl text-blue-500">folder_shared</span></div>
                            <p class="text-slate-500 dark:text-[#9ba0bb] text-sm font-medium mb-1">Total Laporan Masuk</p>
                            <h2 class="text-3xl font-bold text-slate-900 dark:text-white">{{ $stats['total'] }}</h2>
                            <div class="mt-4 h-1 w-full bg-slate-100 dark:bg-[#0f1323] rounded-full">
                                <div class="h-full bg-blue-500 w-full rounded-full"></div>
                            </div>
                        </div>
                        <div
                            class="bg-white dark:bg-[#1a1f33] p-5 rounded-xl border border-slate-200 dark:border-white/5 relative overflow-hidden group shadow-sm">
                            <div class="absolute top-0 right-0 p-4 opacity-10"><span
                                    class="material-symbols-outlined text-6xl text-red-500">campaign</span></div>
                            <p class="text-slate-500 dark:text-[#9ba0bb] text-sm font-medium mb-1">Status Kritis / Emergency
                            </p>
                            <h2 class="text-3xl font-bold text-slate-900 dark:text-white">{{ $stats['critical'] }}</h2>
                            <div class="mt-4 h-1 w-full bg-slate-100 dark:bg-[#0f1323] rounded-full">
                                <div
                                    class="h-full bg-red-500 w-[{{ $stats['total'] > 0 ? ($stats['critical'] / $stats['total']) * 100 : 0 }}%] rounded-full">
                                </div>
                            </div>
                        </div>
                        <div
                            class="bg-white dark:bg-[#1a1f33] p-5 rounded-xl border border-slate-200 dark:border-white/5 relative overflow-hidden group shadow-sm">
                            <div class="absolute top-0 right-0 p-4 opacity-10"><span
                                    class="material-symbols-outlined text-6xl text-emerald-500">verified</span></div>
                            <p class="text-slate-500 dark:text-[#9ba0bb] text-sm font-medium mb-1">Tervalidasi / Selesai</p>
                            <h2 class="text-3xl font-bold text-slate-900 dark:text-white">{{ $stats['completed'] }}</h2>
                            <div class="mt-4 h-1 w-full bg-slate-100 dark:bg-[#0f1323] rounded-full">
                                <div
                                    class="h-full bg-emerald-500 w-[{{ $stats['total'] > 0 ? ($stats['completed'] / $stats['total']) * 100 : 0 }}%] rounded-full">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <div
                            class="lg:col-span-2 bg-white dark:bg-[#1a1f33] p-6 rounded-xl border border-slate-200 dark:border-white/5 shadow-lg">
                            <h3 class="text-slate-900 dark:text-white font-semibold mb-4">Tren Laporan: Warga vs Petugas
                            </h3>
                            <div class="relative h-72 w-full">
                                <canvas id="trendChart"></canvas>
                            </div>
                        </div>
                        <div
                            class="bg-white dark:bg-[#1a1f33] p-6 rounded-xl border border-slate-200 dark:border-white/5 shadow-lg flex flex-col">
                            <h3 class="text-slate-900 dark:text-white font-semibold mb-4">Status Validasi & Penanganan</h3>
                            <div class="flex-1 flex items-center justify-center relative h-48">
                                <canvas id="statusChart"></canvas>
                            </div>
                        </div>
                    </div>

                    <div x-data="{ tab: 'officer' }"
                        class="bg-white dark:bg-[#1a1f33] rounded-xl border border-slate-200 dark:border-white/5 shadow-lg overflow-hidden">

                        <div class="flex border-b border-slate-200 dark:border-white/5">
                            <button @click="tab = 'officer'"
                                :class="tab === 'officer' ? 'border-primary text-primary bg-primary/5' :
                                    'border-transparent text-slate-500 hover:text-slate-700 dark:text-[#9ba0bb] dark:hover:text-white'"
                                class="flex-1 py-4 text-sm font-bold border-b-2 transition-all flex justify-center items-center gap-2">
                                <span class="material-symbols-outlined text-lg">admin_panel_settings</span> Laporan Petugas
                            </button>
                            <button @click="tab = 'public'"
                                :class="tab === 'public' ? 'border-primary text-primary bg-primary/5' :
                                    'border-transparent text-slate-500 hover:text-slate-700 dark:text-[#9ba0bb] dark:hover:text-white'"
                                class="flex-1 py-4 text-sm font-bold border-b-2 transition-all flex justify-center items-center gap-2">
                                <span class="material-symbols-outlined text-lg">campaign</span> Laporan Warga
                            </button>
                        </div>

                        <div x-show="tab === 'officer'" x-cloak class="overflow-x-auto">
                            <table class="w-full text-sm text-left text-slate-500 dark:text-[#9ba0bb]">
                                <thead class="text-xs text-slate-500 uppercase bg-slate-50 dark:bg-white/5">
                                    <tr>
                                        <th class="px-6 py-4">Kode</th>
                                        <th class="px-6 py-4">Waktu</th>
                                        <th class="px-6 py-4">Pos Pantau</th>
                                        <th class="px-6 py-4">Tinggi Air</th>
                                        <th class="px-6 py-4">Status Hitung</th>
                                        <th class="px-6 py-4">Validasi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-200 dark:divide-white/5">
                                    @forelse ($officerReports as $report)
                                        <tr class="hover:bg-slate-50 dark:hover:bg-white/5 transition-colors">
                                            <td class="px-6 py-4 font-medium text-slate-900 dark:text-white">
                                                {{ $report->report_code }}</td>
                                            <td class="px-6 py-4">{{ $report->created_at->format('d M, H:i') }}</td>
                                            <td class="px-6 py-4 text-slate-900 dark:text-white">
                                                {{ $report->station->name }}</td>
                                            <td class="px-6 py-4 font-bold text-blue-500">{{ $report->water_level }} cm
                                            </td>
                                            <td class="px-6 py-4">
                                                @php
                                                    $calcColor = match ($report->calculated_status) {
                                                        'awas' => 'text-red-500',
                                                        'siaga' => 'text-orange-500',
                                                        default => 'text-emerald-500',
                                                    };
                                                @endphp
                                                <span
                                                    class="{{ $calcColor }} font-bold uppercase text-xs">{{ $report->calculated_status }}</span>
                                            </td>
                                            <td class="px-6 py-4">
                                                @php
                                                    $valColor = match ($report->validation_status) {
                                                        'approved' => 'bg-emerald-100 text-emerald-700',
                                                        'rejected' => 'bg-red-100 text-red-700',
                                                        default => 'bg-slate-100 text-slate-700',
                                                    };
                                                @endphp
                                                <span
                                                    class="{{ $valColor }} px-2 py-1 rounded text-xs font-bold uppercase">{{ $report->validation_status }}</span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="px-6 py-8 text-center">Belum ada data laporan
                                                petugas.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <div class="p-4 border-t border-slate-200 dark:border-white/5">
                                {{ $officerReports->appends(['tab' => 'officer'])->links() }}</div>
                        </div>

                        <div x-show="tab === 'public'" x-cloak class="overflow-x-auto">
                            <table class="w-full text-sm text-left text-slate-500 dark:text-[#9ba0bb]">
                                <thead class="text-xs text-slate-500 uppercase bg-slate-50 dark:bg-white/5">
                                    <tr>
                                        <th class="px-6 py-4">Kode</th>
                                        <th class="px-6 py-4">Waktu</th>
                                        <th class="px-6 py-4">Lokasi</th>
                                        <th class="px-6 py-4">Pelapor</th>
                                        <th class="px-6 py-4">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-200 dark:divide-white/5">
                                    @forelse ($publicReports as $report)
                                        <tr class="hover:bg-slate-50 dark:hover:bg-white/5 transition-colors">
                                            <td class="px-6 py-4 font-medium text-slate-900 dark:text-white">
                                                {{ $report->report_code }}</td>
                                            <td class="px-6 py-4">{{ $report->created_at->format('d M, H:i') }}</td>
                                            <td class="px-6 py-4 truncate max-w-[150px]" title="{{ $report->location }}">
                                                {{ $report->location }}</td>
                                            <td class="px-6 py-4">{{ $report->user->name ?? 'Anonim' }}</td>
                                            <td class="px-6 py-4">
                                                @php
                                                    $statusColor = match ($report->status) {
                                                        'emergency' => 'bg-red-100 text-red-700',
                                                        'diproses' => 'bg-blue-100 text-blue-700',
                                                        'selesai' => 'bg-emerald-100 text-emerald-700',
                                                        default => 'bg-slate-100 text-slate-700',
                                                    };
                                                @endphp
                                                <span
                                                    class="{{ $statusColor }} px-2 py-1 rounded text-xs font-bold uppercase">{{ $report->status }}</span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="px-6 py-8 text-center">Belum ada data laporan warga.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <div class="p-4 border-t border-slate-200 dark:border-white/5">
                                {{ $publicReports->appends(['tab' => 'public'])->links() }}</div>
                        </div>

                    </div>
                </div>
            </div>
        </main>
    </div>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="//unpkg.com/alpinejs" defer></script>

    <script>
        // 1. Date Picker
        flatpickr("#date-range", {
            mode: "range",
            dateFormat: "Y-m-d",
            defaultDate: ["{{ request('start_date') }}", "{{ request('end_date') }}"],
            onChange: function(selectedDates, dateStr, instance) {
                if (selectedDates.length === 2) {
                    document.getElementById('start_date').value = instance.formatDate(selectedDates[0],
                        "Y-m-d");
                    document.getElementById('end_date').value = instance.formatDate(selectedDates[1], "Y-m-d");
                }
            }
        });

        // 2. Trend Chart (Dual Line)
        const ctxTrend = document.getElementById('trendChart').getContext('2d');
        new Chart(ctxTrend, {
            type: 'line',
            data: {
                labels: {!! json_encode($chartLabels) !!},
                datasets: [{
                        label: 'Laporan Warga',
                        data: {!! json_encode($publicTrendData) !!},
                        borderColor: '#607afb', // Blue
                        backgroundColor: 'rgba(96, 122, 251, 0.1)',
                        borderWidth: 2,
                        tension: 0.4,
                        fill: true
                    },
                    {
                        label: 'Laporan Petugas',
                        data: {!! json_encode($officerTrendData) !!},
                        borderColor: '#10b981', // Emerald
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        borderWidth: 2,
                        tension: 0.4,
                        fill: true
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    mode: 'index',
                    intersect: false
                },
                plugins: {
                    legend: {
                        labels: {
                            color: '#9ba0bb'
                        }
                    },
                    tooltip: {
                        backgroundColor: '#1a1f33',
                        titleColor: '#fff',
                        bodyColor: '#9ba0bb',
                        borderColor: 'rgba(255,255,255,0.1)',
                        borderWidth: 1
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(255, 255, 255, 0.05)'
                        },
                        ticks: {
                            color: '#9ba0bb'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: '#9ba0bb'
                        }
                    }
                }
            }
        });

        // 3. Status Chart (Donut)
        const ctxStatus = document.getElementById('statusChart').getContext('2d');
        new Chart(ctxStatus, {
            type: 'doughnut',
            data: {
                labels: ['Selesai/Approved', 'Pending/Proses', 'Rejected', 'Emergency'],
                datasets: [{
                    data: [
                        {{ $chartStatusData['approved'] }},
                        {{ $chartStatusData['pending'] }},
                        {{ $chartStatusData['rejected'] }},
                        {{ $chartStatusData['emergency'] }}
                    ],
                    backgroundColor: ['#10b981', '#f59e0b', '#64748b', '#ef4444'],
                    borderWidth: 0,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right',
                        labels: {
                            color: '#9ba0bb',
                            padding: 20
                        }
                    }
                },
                cutout: '70%'
            }
        });
    </script>
@endsection
