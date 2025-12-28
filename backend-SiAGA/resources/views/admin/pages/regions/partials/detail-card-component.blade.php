<div id="detail-card"
    class="slide-out absolute top-6 right-6 w-96 max-h-[calc(100%-3rem)] flex flex-col bg-[#1a1d2d]/95 backdrop-blur-md border border-[#272a3a] rounded-xl shadow-2xl z-[100] overflow-hidden transition-transform duration-300 ease-in-out">

    <div class="relative h-32 bg-slate-800 flex items-center justify-center overflow-hidden">
        <div class="absolute inset-0 opacity-30"
            style="background-image: radial-gradient(#4b5563 1px, transparent 1px); background-size: 10px 10px;"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-[#1a1d2d] to-transparent"></div>

        <button onclick="closeDetailCard()"
            class="absolute top-3 right-3 p-1.5 rounded-full bg-black/40 text-white hover:bg-black/60 transition-colors z-10">
            <span class="material-symbols-outlined text-lg">close</span>
        </button>

        <div class="absolute bottom-3 left-4 z-10">
            <span id="detail-badge"
                class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-bold bg-slate-500 text-white mb-1 uppercase tracking-wide">
                Loading...
            </span>
            <h3 id="detail-title" class="text-white font-bold text-xl leading-none shadow-black drop-shadow-md">
                Memuat Data...
            </h3>
        </div>
    </div>

    <div class="p-5 overflow-y-auto custom-scrollbar">
        <div class="grid grid-cols-2 gap-3 mb-6">
            <div class="bg-black/20 p-3 rounded-lg border border-white/5">
                <span class="block text-slate-400 text-xs mb-1">Koordinat</span>
                <span id="detail-latlng" class="block text-white font-bold text-xs">-</span>
            </div>
            <div class="bg-black/20 p-3 rounded-lg border border-white/5">
                <span class="block text-slate-400 text-xs mb-1">Status</span>
                <span id="detail-status-text" class="block text-white font-bold text-sm uppercase">-</span>
            </div>
        </div>

        <div class="mb-6">
            <h5 class="text-sm font-bold text-white flex items-center gap-2 mb-2">
                <span class="material-symbols-outlined text-primary text-lg">note_alt</span>
                Catatan Risiko
            </h5>
            <p id="detail-note"
                class="text-sm text-slate-300 leading-relaxed bg-white/5 p-3 rounded-lg border border-white/5">
                -
            </p>
        </div>

        <div>
            <h5 class="text-sm font-bold text-white flex items-center gap-2 mb-3">
                <span class="material-symbols-outlined text-primary text-lg">sensors</span>
                Dipengaruhi Oleh
            </h5>
            <div id="detail-influenced" class="flex flex-col gap-2">
            </div>
        </div>
    </div>

    <div class="p-4 bg-black/20 border-t border-white/10">
        <a id="detail-edit-link" href="#"
            class="block w-full py-2 px-4 rounded-lg bg-primary hover:bg-blue-600 text-white text-center text-sm font-bold transition-colors shadow-lg">
            Edit Data Wilayah
        </a>
    </div>
</div>
