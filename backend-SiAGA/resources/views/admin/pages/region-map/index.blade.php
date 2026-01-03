@extends('admin.layouts.app')

@section('breadcrumbs')
    <span class="material-symbols-outlined text-sm ...">chevron_right</span>
    <span class="text-sm font-medium text-slate-900 dark:text-white">Potensi Banjir</span>
@endsection

@section('css')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        /* Paksa peta memenuhi ruang */
        #map-container {
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            z-index: 1;
        }

        #map {
            width: 100%;
            height: 100%;
            background: #15171e;
        }

        /* Styling Popup Leaflet */
        .leaflet-popup-content-wrapper {
            background-color: #1a1d2d;
            color: white;
            border: 1px solid #272a3a;
            border-radius: 0.5rem;
        }

        .leaflet-popup-tip {
            background-color: #1a1d2d;
        }

        /* --- PERBAIKAN DI SINI --- */
        /* Animasi Slide untuk Detail Card */
        .slide-in {
            transform: translateX(0%);
        }

        .slide-out {
            /* Geser 100% lebar kartu + 2rem (sekitar 32px) untuk margin kanan & shadow */
            transform: translateX(calc(100% + 2rem));
        }
    </style>
@endsection

@section('content')
    <div class="flex h-screen w-full overflow-hidden">
        @include('admin.includes.sidebar')

        <main class="flex-1 flex flex-col min-w-0 bg-background-light dark:bg-background-dark">
            @include('admin.includes.header')

            <div class="flex flex-1 overflow-hidden relative">
                <div
                    class="w-[400px] flex-shrink-0 flex flex-col border-r border-gray-200 dark:border-border-dark bg-white dark:bg-[#15171e] z-20 relative">
                    @livewire('admin.region-manager')
                </div>

                <div class="flex-1 relative bg-gray-900" wire:ignore>
                    <div id="map-container">
                        <div id="map"></div>
                    </div>

                    <div class="absolute bottom-8 right-8 flex flex-col gap-2 z-[50]">
                        <div
                            class="flex flex-col rounded-lg bg-surface-dark shadow-xl border border-border-dark overflow-hidden">
                            <button onclick="map.zoomIn()"
                                class="p-2.5 hover:bg-white/5 text-white flex items-center justify-center border-b border-white/5 bg-slate-800">
                                <span class="material-symbols-outlined">add</span>
                            </button>
                            <button onclick="map.zoomOut()"
                                class="p-2.5 hover:bg-white/5 text-white flex items-center justify-center bg-slate-800">
                                <span class="material-symbols-outlined">remove</span>
                            </button>
                        </div>
                        <button onclick="resetMap()"
                            class="p-2.5 rounded-lg bg-surface-dark shadow-xl text-white hover:bg-white/5 border border-border-dark flex items-center justify-center bg-slate-800"
                            title="Reset View">
                            <span class="material-symbols-outlined">my_location</span>
                        </button>
                    </div>

                    <div id="detail-card"
                        class="slide-out absolute top-6 right-6 w-96 max-h-[calc(100%-3rem)] flex flex-col bg-[#1a1d2d]/95 backdrop-blur-md border border-[#272a3a] rounded-xl shadow-2xl z-[100] overflow-hidden transition-transform duration-300 ease-in-out">
                        <div class="relative h-32 bg-slate-800 flex items-center justify-center overflow-hidden">
                            <div class="absolute inset-0 bg-gradient-to-t from-[#1a1d2d] to-transparent"></div>
                            <button onclick="closeDetailCard()"
                                class="absolute top-3 right-3 p-1.5 rounded-full bg-black/40 text-white hover:bg-black/60 transition-colors z-10">
                                <span class="material-symbols-outlined text-lg">close</span>
                            </button>
                            <div class="absolute bottom-3 left-4 z-10">
                                <span id="detail-badge"
                                    class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-bold bg-slate-500 text-white mb-1 uppercase tracking-wide">INFO</span>
                                <h3 id="detail-title"
                                    class="text-white font-bold text-xl leading-none shadow-black drop-shadow-md">Pilih
                                    Wilayah</h3>
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
                                    <span id="detail-status-text"
                                        class="block text-white font-bold text-sm uppercase">-</span>
                                </div>
                            </div>
                            <div class="mb-6">
                                <h5 class="text-sm font-bold text-white flex items-center gap-2 mb-2">
                                    <span class="material-symbols-outlined text-primary text-lg">note_alt</span> Catatan
                                    Risiko
                                </h5>
                                <p id="detail-note"
                                    class="text-sm text-slate-300 leading-relaxed bg-white/5 p-3 rounded-lg border border-white/5">
                                    -</p>
                            </div>
                            <div>
                                <h5 class="text-sm font-bold text-white flex items-center gap-2 mb-3">
                                    <span class="material-symbols-outlined text-primary text-lg">sensors</span> Dipengaruhi
                                    Oleh
                                </h5>
                                <div id="detail-influenced" class="flex flex-col gap-2"></div>
                            </div>
                        </div>
                        <div class="p-4 bg-black/20 border-t border-white/10">
                            <a id="detail-edit-link" href="#"
                                class="block w-full py-2 px-4 rounded-lg bg-primary hover:bg-blue-600 text-white text-center text-sm font-bold transition-colors shadow-lg">Edit
                                Data Wilayah</a>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
@endsection

@section('script')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        // Ambil data dari Controller dengan aman
        const regionsData = @json($mapData ?? []);
        console.log("Data Peta Dimuat:", regionsData);

        let map;

        document.addEventListener('DOMContentLoaded', function() {
            // 1. Inisialisasi Peta
            // Pastikan elemen map ada sebelum inisialisasi
            const mapContainer = document.getElementById('map');
            if (mapContainer) {
                map = L.map('map', {
                    zoomControl: false
                }).setView([-6.2088, 106.8456], 12);

                L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
                    attribution: '&copy; CARTO',
                    maxZoom: 20
                }).addTo(map);

                // 2. Render Marker
                regionsData.forEach(region => {
                    if (region.lat && region.lng) {
                        const color = getStatusColor(region.status);

                        // PERBAIKAN: Gunakan Template Literal (backtick) dengan benar
                        // Hapus spasi berlebih untuk keamanan
                        const iconHtml = `
                            <div class="relative flex items-center justify-center size-8 cursor-pointer hover:scale-110 transition-transform">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-${color}-500 opacity-20"></span>
                                <div class="relative inline-flex rounded-full h-6 w-6 bg-${color}-600 border-2 border-white shadow-lg items-center justify-center">
                                    <span class="material-symbols-outlined text-white text-[14px]">flood</span>
                                </div>
                            </div>
                        `.trim(); // Trim untuk menghapus whitespace yang tidak perlu

                        const icon = L.divIcon({
                            className: 'bg-transparent border-none',
                            html: iconHtml,
                            iconSize: [32, 32],
                            iconAnchor: [16, 16]
                        });

                        const marker = L.marker([region.lat, region.lng], {
                            icon: icon
                        }).addTo(map);

                        marker.on('click', () => {
                            openDetail(region);
                            map.flyTo([region.lat, region.lng], 15, {
                                animate: true,
                                duration: 1
                            });
                        });
                    }
                });
            } else {
                console.error("Elemen #map tidak ditemukan di DOM");
            }

            // 3. Livewire Listener
            if (typeof Livewire !== 'undefined') {
                Livewire.on('region-selected', (event) => {
                    // Penanganan event data yang fleksibel
                    const data = Array.isArray(event) ? event[0] : event;
                    const {
                        lat,
                        lng
                    } = data || {};

                    if (lat && lng) {
                        map.flyTo([lat, lng], 15, {
                            animate: true,
                            duration: 0.5
                        });

                        // Cari data region yang cocok (menggunakan toleransi float kecil)
                        const region = regionsData.find(r =>
                            Math.abs(r.lat - lat) < 0.0001 && Math.abs(r.lng - lng) < 0.0001
                        );

                        if (region) openDetail(region);
                    }
                });
            }
        });

        // Helper Functions
        function openDetail(region) {
            const card = document.getElementById('detail-card');
            const color = getStatusColor(region.status);

            // Set Text Content (Lebih aman dari innerHTML untuk teks biasa)
            document.getElementById('detail-title').textContent = region.name;
            document.getElementById('detail-latlng').textContent = `${region.lat}, ${region.lng}`;
            document.getElementById('detail-status-text').textContent = region.status;
            document.getElementById('detail-note').textContent = region.note || '-';

            // Build Influenced List HTML
            const influenceList = document.getElementById('detail-influenced');
            if (region.influenced_by) {
                const stations = region.influenced_by.split(', ');
                // Gunakan map dan join untuk membuat string HTML yang valid
                const htmlContent = stations.map(st => `
                    <div class="flex items-center gap-2 p-2 rounded bg-white/5 border border-white/10">
                        <div class="size-2 rounded-full bg-blue-500"></div>
                        <span class="text-sm text-slate-300">${st}</span>
                    </div>
                `).join('');
                influenceList.innerHTML = htmlContent;
            } else {
                influenceList.innerHTML = '<span class="text-xs text-slate-500 italic">Belum ada data stasiun.</span>';
            }

            // Update Badge Class
            const badge = document.getElementById('detail-badge');
            badge.className =
                `inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-bold bg-${color}-500 text-white mb-1 uppercase tracking-wide`;
            badge.textContent = region.status;

            // Update Link
            const editLink = document.getElementById('detail-edit-link');
            if (editLink) editLink.href = `/admin/regions/${region.id}/edit`;

            // Show Card
            if (card) {
                card.classList.remove('slide-out');
                card.classList.add('slide-in');
            }
        }

        function closeDetailCard() {
            const card = document.getElementById('detail-card');
            if (card) {
                card.classList.remove('slide-in');
                card.classList.add('slide-out');
            }
        }

        function resetMap() {
            if (map) {
                map.flyTo([-6.2088, 106.8456], 12);
                closeDetailCard();
            }
        }

        function getStatusColor(status) {
            if (status === 'awas') return 'red';
            if (status === 'siaga') return 'orange';
            return 'green';
        }
    </script>
@endsection
