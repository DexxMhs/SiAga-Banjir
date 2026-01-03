<div
    class="w-full max-w-[400px] flex flex-col border-r border-gray-200 dark:border-border-dark bg-white dark:bg-[#15171e] z-10 shadow-xl h-full">

    <div class="bg-white dark:bg-[#15171e] shadow-sm z-20">
        <div class="p-5 pb-2 border-b border-gray-100 dark:border-border-dark flex items-center justify-between">
            <h3 class="text-slate-900 dark:text-white font-bold text-lg">Peta Terpadu</h3>
            <div wire:loading class="text-primary text-xs font-bold animate-pulse">Memuat...</div>
        </div>

        <div class="grid grid-cols-4 px-2 pt-2">
            <button wire:click="$set('activeTab', 'regions')"
                class="pb-3 text-xs md:text-sm font-semibold border-b-2 transition-colors flex flex-col items-center gap-1
                {{ $activeTab === 'regions' ? 'border-primary text-primary' : 'border-transparent text-slate-500 hover:text-slate-700 dark:text-slate-400' }}">
                <span class="material-symbols-outlined text-[20px]">flood</span>
                <span class="hidden sm:inline">Wilayah</span>
            </button>
            <button wire:click="$set('activeTab', 'stations')"
                class="pb-3 text-xs md:text-sm font-semibold border-b-2 transition-colors flex flex-col items-center gap-1
                {{ $activeTab === 'stations' ? 'border-blue-500 text-blue-500' : 'border-transparent text-slate-500 hover:text-slate-700 dark:text-slate-400' }}">
                <span class="material-symbols-outlined text-[20px]">sensors</span>
                <span class="hidden sm:inline">Pos</span>
            </button>
            <button wire:click="$set('activeTab', 'facilities')"
                class="pb-3 text-xs md:text-sm font-semibold border-b-2 transition-colors flex flex-col items-center gap-1
                {{ $activeTab === 'facilities' ? 'border-purple-500 text-purple-500' : 'border-transparent text-slate-500 hover:text-slate-700 dark:text-slate-400' }}">
                <span class="material-symbols-outlined text-[20px]">domain</span>
                <span class="hidden sm:inline">Fasilitas</span>
            </button>
            {{-- [BARU] Tab Laporan --}}
            <button wire:click="$set('activeTab', 'reports')"
                class="pb-3 text-xs md:text-sm font-semibold border-b-2 transition-colors flex flex-col items-center gap-1
                {{ $activeTab === 'reports' ? 'border-orange-500 text-orange-500' : 'border-transparent text-slate-500 hover:text-slate-700 dark:text-slate-400' }}">
                <span class="material-symbols-outlined text-[20px]">campaign</span>
                <span class="hidden sm:inline">Laporan</span>
            </button>
        </div>
    </div>

    <div
        class="p-4 border-b border-gray-200 dark:border-border-dark flex flex-col gap-3 bg-gray-50/50 dark:bg-[#1a1d2d]">
        <div class="relative">
            <span
                class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-[20px]">search</span>
            <input wire:model.live.debounce.300ms="search"
                class="w-full bg-white dark:bg-[#111218] border border-gray-200 dark:border-border-dark rounded-lg py-2 pl-10 pr-4 text-sm text-slate-900 dark:text-white focus:ring-primary focus:border-primary shadow-sm"
                placeholder="Cari {{ match ($activeTab) {'regions' => 'wilayah','stations' => 'pos pantau','facilities' => 'fasilitas','reports' => 'laporan'} }}..."
                type="text" />
        </div>

        <div class="flex gap-2 overflow-x-auto pb-1 scrollbar-hide">
            <button wire:click="setFilter('')"
                class="flex items-center gap-1.5 px-3 py-1.5 rounded-full border text-xs font-medium transition-all whitespace-nowrap {{ $statusFilter == '' ? 'bg-slate-800 text-white border-slate-800' : 'bg-white dark:bg-surface-dark border-gray-200 dark:border-border-dark text-slate-500' }}">
                <span>Semua</span>
                <span class="bg-white/20 px-1.5 rounded text-[10px]">{{ $stats['all'] ?? 0 }}</span>
            </button>

            @if ($activeTab === 'facilities')
                <button wire:click="setFilter('buka')"
                    class="flex items-center gap-1.5 px-3 py-1.5 rounded-full border text-xs font-medium transition-all whitespace-nowrap {{ $statusFilter == 'buka' ? 'bg-green-500/20 border-green-500 text-green-600' : 'bg-white dark:bg-surface-dark border-gray-200 text-green-600' }}">
                    <span class="size-2 rounded-full bg-green-500"></span> Buka ({{ $stats['buka'] ?? 0 }})
                </button>
                <button wire:click="setFilter('penuh')"
                    class="flex items-center gap-1.5 px-3 py-1.5 rounded-full border text-xs font-medium transition-all whitespace-nowrap {{ $statusFilter == 'penuh' ? 'bg-orange-500/20 border-orange-500 text-orange-600' : 'bg-white dark:bg-surface-dark border-gray-200 text-orange-600' }}">
                    <span class="size-2 rounded-full bg-orange-500"></span> Penuh ({{ $stats['penuh'] ?? 0 }})
                </button>
                <button wire:click="setFilter('tutup')"
                    class="flex items-center gap-1.5 px-3 py-1.5 rounded-full border text-xs font-medium transition-all whitespace-nowrap {{ $statusFilter == 'tutup' ? 'bg-slate-500/20 border-slate-500 text-slate-600' : 'bg-white dark:bg-surface-dark border-gray-200 text-slate-600' }}">
                    <span class="size-2 rounded-full bg-slate-500"></span> Tutup ({{ $stats['tutup'] ?? 0 }})
                </button>
            @elseif ($activeTab === 'reports')
                {{-- [BARU] Filter Laporan --}}
                <button wire:click="setFilter('emergency')"
                    class="flex items-center gap-1.5 px-3 py-1.5 rounded-full border text-xs font-medium transition-all whitespace-nowrap {{ $statusFilter == 'emergency' ? 'bg-red-500/20 border-red-500 text-red-600' : 'bg-white dark:bg-surface-dark border-gray-200 text-red-600' }}">
                    <span class="size-2 rounded-full bg-red-500 animate-pulse"></span> Emergency
                    ({{ $stats['emergency'] ?? 0 }})
                </button>
                <button wire:click="setFilter('diproses')"
                    class="flex items-center gap-1.5 px-3 py-1.5 rounded-full border text-xs font-medium transition-all whitespace-nowrap {{ $statusFilter == 'diproses' ? 'bg-blue-500/20 border-blue-500 text-blue-600' : 'bg-white dark:bg-surface-dark border-gray-200 text-blue-600' }}">
                    <span class="size-2 rounded-full bg-blue-500"></span> Proses ({{ $stats['diproses'] ?? 0 }})
                </button>
                <button wire:click="setFilter('pending')"
                    class="flex items-center gap-1.5 px-3 py-1.5 rounded-full border text-xs font-medium transition-all whitespace-nowrap {{ $statusFilter == 'pending' ? 'bg-yellow-500/20 border-yellow-500 text-yellow-600' : 'bg-white dark:bg-surface-dark border-gray-200 text-yellow-600' }}">
                    <span class="size-2 rounded-full bg-yellow-500"></span> Pending ({{ $stats['pending'] ?? 0 }})
                </button>
            @else
                {{-- Filter Wilayah & Station --}}
                <button wire:click="setFilter('awas')"
                    class="flex items-center gap-1.5 px-3 py-1.5 rounded-full border text-xs font-medium transition-all whitespace-nowrap {{ $statusFilter == 'awas' ? 'bg-red-500/20 border-red-500 text-red-600' : 'bg-white dark:bg-surface-dark border-gray-200 text-red-600' }}">
                    <span class="size-2 rounded-full bg-red-500"></span> Awas ({{ $stats['awas'] ?? 0 }})
                </button>
                <button wire:click="setFilter('siaga')"
                    class="flex items-center gap-1.5 px-3 py-1.5 rounded-full border text-xs font-medium transition-all whitespace-nowrap {{ $statusFilter == 'siaga' ? 'bg-orange-500/20 border-orange-500 text-orange-600' : 'bg-white dark:bg-surface-dark border-gray-200 text-orange-600' }}">
                    <span class="size-2 rounded-full bg-orange-500"></span> Siaga ({{ $stats['siaga'] ?? 0 }})
                </button>
                <button wire:click="setFilter('normal')"
                    class="flex items-center gap-1.5 px-3 py-1.5 rounded-full border text-xs font-medium transition-all whitespace-nowrap {{ $statusFilter == 'normal' ? 'bg-green-500/20 border-green-500 text-green-600' : 'bg-white dark:bg-surface-dark border-gray-200 text-green-600' }}">
                    <span class="size-2 rounded-full bg-green-500"></span> Normal ({{ $stats['normal'] ?? 0 }})
                </button>
            @endif
        </div>
    </div>

    <div class="flex-1 overflow-y-auto p-3 flex flex-col gap-3 custom-scrollbar">
        @forelse ($items as $item)
            <div wire:click="selectItem({{ $item->id }}, {{ $item->latitude }}, {{ $item->longitude }})"
                class="group relative flex flex-col p-4 rounded-xl border cursor-pointer transition-all shadow-sm
                {{ $selectedId == $item->id
                    ? 'bg-primary/5 dark:bg-primary/10 border-primary/50 dark:border-primary/50 ring-1 ring-primary/30'
                    : 'bg-white dark:bg-surface-dark border-gray-100 dark:border-border-dark hover:border-slate-300 dark:hover:border-slate-600' }}">

                <div class="flex justify-between items-start mb-2">
                    <div class="flex flex-col">
                        <h4
                            class="text-slate-900 dark:text-white font-semibold text-sm group-hover:text-primary transition-colors line-clamp-1">
                            @if ($activeTab == 'reports')
                                {{ $item->report_code }}
                            @else
                                {{ $item->name }}
                            @endif
                        </h4>

                        <span class="text-xs text-slate-500 dark:text-slate-400">
                            @if ($activeTab == 'regions')
                                {{ $item->location ?? 'Lokasi tidak tersedia' }}
                            @elseif($activeTab == 'stations')
                                ID: {{ $item->station_code }}
                            @elseif($activeTab == 'facilities')
                                {{ ucwords(str_replace('_', ' ', $item->type)) }}
                            @elseif($activeTab == 'reports')
                                {{-- [BARU] Info Pelapor --}}
                                <span class="flex items-center gap-1 mt-0.5">
                                    <span class="material-symbols-outlined text-[12px]">person</span>
                                    {{ $item->user->name ?? 'Anonim' }}
                                </span>
                            @endif
                        </span>
                    </div>

                    @php
                        // Logika Warna Badge Status
                        $status =
                            $activeTab == 'facilities'
                                ? $item->status
                                : ($activeTab == 'regions'
                                    ? $item->flood_status
                                    : $item->status);

                        $badgeColor = match ($status) {
                            'awas',
                            'penuh',
                            'emergency'
                                => 'bg-red-100 text-red-700 dark:bg-red-500/10 dark:text-red-400',
                            'siaga',
                            'tutup',
                            'pending'
                                => 'bg-orange-100 text-orange-700 dark:bg-orange-500/10 dark:text-orange-400', // Pending/Tutup = Kuning/Orange
                            'normal', 'buka' => 'bg-green-100 text-green-700 dark:bg-green-500/10 dark:text-green-400',
                            'diproses',
                            'verified'
                                => 'bg-blue-100 text-blue-700 dark:bg-blue-500/10 dark:text-blue-400',
                            default => 'bg-slate-100 text-slate-700',
                        };

                        // Custom override jika pending mau kuning
                        if ($status == 'pending') {
                            $badgeColor = 'bg-yellow-100 text-yellow-700 dark:bg-yellow-500/10 dark:text-yellow-400';
                        }
                    @endphp

                    <div class="px-2 py-0.5 rounded text-[10px] font-bold uppercase {{ $badgeColor }}">
                        {{ $status }}
                    </div>
                </div>

                <div class="flex items-center gap-2 mt-1">
                    @if ($activeTab == 'stations')
                        <div
                            class="flex items-center gap-1 text-xs font-bold text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-500/10 px-2 py-1 rounded">
                            <span class="material-symbols-outlined text-[14px]">water_drop</span>
                            {{ $item->water_level }} cm
                        </div>
                    @elseif($activeTab == 'regions')
                        <p class="text-xs text-slate-500 line-clamp-1 italic">
                            {{ $item->risk_note ?? 'Tidak ada catatan risiko.' }}
                        </p>
                    @elseif($activeTab == 'facilities')
                        <p class="text-xs text-slate-500 line-clamp-1">
                            {{ $item->address }}
                        </p>
                    @elseif($activeTab == 'reports')
                        {{-- [BARU] Info Tinggi Air & Waktu --}}
                        <div class="flex items-center gap-3 w-full">
                            <div
                                class="flex items-center gap-1 text-xs font-bold text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-500/10 px-2 py-1 rounded">
                                <span class="material-symbols-outlined text-[14px]">water</span>
                                {{ $item->water_level }} cm
                            </div>
                            <span class="text-[10px] text-slate-400 ml-auto">
                                {{ $item->created_at->diffForHumans() }}
                            </span>
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="flex flex-col items-center justify-center h-40 text-center p-4">
                <span
                    class="material-symbols-outlined text-4xl text-slate-300 dark:text-slate-600 mb-2">search_off</span>
                <p class="text-sm text-slate-500">Tidak ada data ditemukan.</p>
            </div>
        @endforelse

        <div class="mt-2 px-1">
            {{ $items->links(data: ['scrollTo' => false]) }}
        </div>
    </div>
</div>
