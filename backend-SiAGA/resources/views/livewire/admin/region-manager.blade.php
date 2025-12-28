<div
    class="w-full max-w-[400px] flex flex-col border-r border-gray-200 dark:border-border-dark bg-white dark:bg-[#15171e] z-10 shadow-xl h-full">

    <div class="p-5 border-b border-gray-200 dark:border-border-dark flex flex-col gap-4">
        <div class="flex items-center justify-between">
            <h3 class="text-slate-900 dark:text-white font-bold text-lg">Daftar Wilayah</h3>
            <div wire:loading class="text-primary text-xs font-bold animate-pulse">Memuat...</div>
        </div>

        <div class="relative">
            <span
                class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-[20px]">search</span>
            <input wire:model.live.debounce.300ms="search"
                class="w-full bg-gray-50 dark:bg-surface-dark border border-gray-200 dark:border-border-dark rounded-lg py-2 pl-10 pr-4 text-sm text-slate-900 dark:text-white focus:ring-primary focus:border-primary"
                placeholder="Cari nama wilayah..." type="text" />
        </div>

        <div class="flex gap-2 overflow-x-auto pb-1 scrollbar-hide">
            <button wire:click="setFilter('')"
                class="flex items-center gap-1.5 px-3 py-1.5 rounded-full border text-xs font-medium transition-all whitespace-nowrap {{ $statusFilter == '' ? 'bg-primary/20 border-primary text-primary' : 'bg-slate-100 dark:bg-surface-dark border-transparent text-slate-500' }}">
                <span>Semua</span>
                <span class="bg-black/10 dark:bg-white/10 px-1.5 rounded text-[10px]">{{ $stats['all'] }}</span>
            </button>
            <button wire:click="setFilter('awas')"
                class="flex items-center gap-1.5 px-3 py-1.5 rounded-full border text-xs font-medium transition-all whitespace-nowrap {{ $statusFilter == 'awas' ? 'bg-red-500/20 border-red-500 text-red-500' : 'bg-red-500/10 border-transparent text-red-600 dark:text-red-400' }}">
                <span class="size-2 rounded-full bg-red-500"></span>
                <span>Awas</span>
                <span class="bg-black/10 dark:bg-white/10 px-1.5 rounded text-[10px]">{{ $stats['awas'] }}</span>
            </button>
            <button wire:click="setFilter('siaga')"
                class="flex items-center gap-1.5 px-3 py-1.5 rounded-full border text-xs font-medium transition-all whitespace-nowrap {{ $statusFilter == 'siaga' ? 'bg-orange-500/20 border-orange-500 text-orange-500' : 'bg-orange-500/10 border-transparent text-orange-600 dark:text-orange-400' }}">
                <span class="size-2 rounded-full bg-orange-500"></span>
                <span>Siaga</span>
                <span class="bg-black/10 dark:bg-white/10 px-1.5 rounded text-[10px]">{{ $stats['siaga'] }}</span>
            </button>
            <button wire:click="setFilter('normal')"
                class="flex items-center gap-1.5 px-3 py-1.5 rounded-full border text-xs font-medium transition-all whitespace-nowrap {{ $statusFilter == 'normal' ? 'bg-green-500/20 border-green-500 text-green-500' : 'bg-green-500/10 border-transparent text-green-600 dark:text-green-400' }}">
                <span class="size-2 rounded-full bg-green-500"></span>
                <span>Normal</span>
                <span class="bg-black/10 dark:bg-white/10 px-1.5 rounded text-[10px]">{{ $stats['normal'] }}</span>
            </button>
        </div>
    </div>

    <div class="flex-1 overflow-y-auto p-3 flex flex-col gap-3">
        @foreach ($regions as $region)
            <div wire:click="selectRegion({{ $region->id }})"
                class="group relative flex flex-col p-4 rounded-xl border cursor-pointer transition-all shadow-sm
                 {{ $selectedRegionId == $region->id
                     ? 'bg-primary/5 dark:bg-primary/10 border-primary/50 dark:border-primary/50 ring-1 ring-primary/30'
                     : ' dark:bg-surface-dark border-gray-100 dark:border-border-dark hover:border-slate-300 dark:hover:border-slate-600' }}">

                <div class="flex justify-between items-start mb-2">
                    <div class="flex flex-col">
                        @if ($selectedRegionId == $region->id)
                            <span class="text-xs font-bold text-primary mb-1 uppercase tracking-wider">Terpilih</span>
                        @endif
                        <h4
                            class="text-slate-900 dark:text-white font-semibold text-base group-hover:text-primary transition-colors">
                            {{ $region->name }}
                        </h4>
                    </div>
                    <div
                        class="px-2.5 py-1 rounded-md text-xs font-bold uppercase
                        {{ $region->flood_status == 'awas' ? 'bg-red-500/10 text-red-500' : '' }}
                        {{ $region->flood_status == 'siaga' ? 'bg-orange-500/10 text-orange-500' : '' }}
                        {{ $region->flood_status == 'normal' ? 'bg-green-500/10 text-green-500' : '' }}">
                        {{ $region->flood_status }}
                    </div>
                </div>

                <p class="text-slate-500 dark:text-slate-400 text-sm mb-3 line-clamp-2">
                    {{ $region->risk_note ?? 'Tidak ada catatan.' }}
                </p>
            </div>
        @endforeach

        <div class="mt-4 px-2">
            {{ $regions->links(data: ['scrollTo' => false]) }}
        </div>
    </div>
</div>
