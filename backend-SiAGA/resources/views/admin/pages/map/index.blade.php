@extends('admin.layouts.app')

@section('breadcrumbs')
    <span class="material-symbols-outlined text-sm text-slate-500">chevron_right</span>
    <span class="text-sm font-medium text-slate-900 dark:text-white">Peta Sebaran Terpadu</span>
@endsection

@section('css')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
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

        /* Animasi Slide Card */
        .slide-in {
            transform: translateX(0%);
        }

        .slide-out {
            transform: translateX(calc(100% + 2rem));
        }

        /* Custom Scrollbar */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        /* Leaflet Popups */
        .leaflet-popup-content-wrapper,
        .leaflet-popup-tip {
            background: #1a1d2d;
            color: white;
            border: 1px solid #272a3a;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.5);
        }

        .leaflet-popup-content {
            margin: 10px 14px;
            line-height: 1.4;
        }

        /* Leaflet Controls */
        .leaflet-control-layers {
            background: #1a1d2d !important;
            border: 1px solid #272a3a !important;
            color: #ccc !important;
            border-radius: 0.5rem !important;
        }

        .leaflet-control-layers-separator {
            border-top: 1px solid #333;
        }
    </style>
@endsection

@section('content')
    <div class="flex h-screen w-full overflow-hidden">
        @include('admin.includes.sidebar')

        <main class="flex-1 flex flex-col min-w-0 bg-background-light dark:bg-background-dark">
            @include('admin.includes.header')

            <div class="flex flex-1 overflow-hidden relative">

                {{-- Sidebar List (Livewire) --}}
                <div
                    class="w-[400px] hidden md:flex flex-col border-r border-gray-200 dark:border-border-dark bg-white dark:bg-[#15171e] z-20 relative shadow-xl">
                    @livewire('admin.map-sidebar')
                </div>

                {{-- Map Container --}}
                <div class="flex-1 relative bg-gray-900" wire:ignore>
                    <div id="map-container">
                        <div id="map"></div>
                    </div>

                    {{-- Tombol Zoom & Reset --}}
                    <div class="absolute bottom-8 right-8 flex flex-col gap-2 z-[400]">
                        <div
                            class="flex flex-col rounded-lg bg-surface-dark shadow-xl border border-border-dark overflow-hidden">
                            <button onclick="map.zoomIn()"
                                class="p-2.5 hover:bg-white/10 text-white flex items-center justify-center border-b border-white/10 bg-slate-800 transition-colors">
                                <span class="material-symbols-outlined">add</span>
                            </button>
                            <button onclick="map.zoomOut()"
                                class="p-2.5 hover:bg-white/10 text-white flex items-center justify-center bg-slate-800 transition-colors">
                                <span class="material-symbols-outlined">remove</span>
                            </button>
                        </div>
                        <button onclick="resetMap()"
                            class="p-2.5 rounded-lg bg-surface-dark shadow-xl text-white hover:bg-white/10 border border-border-dark flex items-center justify-center bg-slate-800 transition-colors"
                            title="Reset View">
                            <span class="material-symbols-outlined">my_location</span>
                        </button>
                    </div>

                    {{-- DETAIL CARD --}}
                    <div id="detail-card"
                        class="slide-out absolute top-6 right-6 w-96 max-h-[calc(100%-3rem)] flex flex-col bg-[#1a1d2d]/95 backdrop-blur-md border border-[#272a3a] rounded-xl shadow-2xl z-[1000] overflow-hidden transition-transform duration-500 cubic-bezier(0.4, 0, 0.2, 1)">

                        {{-- Header Card --}}
                        <div class="relative h-36 bg-slate-800 flex items-center justify-center overflow-hidden shrink-0">
                            <div class="absolute inset-0 opacity-10"
                                style="background-image: radial-gradient(#fff 1px, transparent 1px); background-size: 20px 20px;">
                            </div>
                            <div class="absolute inset-0 bg-gradient-to-t from-[#1a1d2d] to-transparent"></div>

                            <button onclick="closeDetailCard()"
                                class="absolute top-3 right-3 p-1.5 rounded-full bg-black/40 text-white hover:bg-black/60 transition-colors z-10 backdrop-blur-sm">
                                <span class="material-symbols-outlined text-lg">close</span>
                            </button>

                            <div class="absolute bottom-4 left-5 z-10 w-full pr-8">
                                <span id="detail-badge"
                                    class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded text-[10px] font-bold bg-slate-600 text-white mb-2 uppercase tracking-wider shadow-sm">
                                    INFO
                                </span>
                                <h3 id="detail-title"
                                    class="text-white font-bold text-2xl leading-tight shadow-black drop-shadow-md truncate">
                                    Memilih...
                                </h3>
                            </div>
                        </div>

                        {{-- Body Card --}}
                        <div id="detail-body" class="p-5 overflow-y-auto custom-scrollbar flex-1"></div>

                        {{-- Footer Action --}}
                        <div class="p-4 bg-black/30 border-t border-white/5 shrink-0">
                            <a id="detail-edit-link" href="#"
                                class="block w-full py-2.5 px-4 rounded-lg bg-primary hover:bg-blue-600 text-white text-center text-sm font-bold transition-all shadow-lg hover:shadow-primary/25">
                                Lihat Detail
                            </a>
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
        // Data Global dari Controller (Regions, Stations, Facilities, Reports)
        const mapData = {!! json_encode($mapData ?? ['regions' => [], 'stations' => [], 'facilities' => [], 'reports' => []]) !!};
        let map;

        // Layer Groups
        const layers = {
            regions: L.layerGroup(),
            stations: L.layerGroup(),
            facilities: L.layerGroup(),
            reports: L.layerGroup() // Layer untuk Laporan Warga
        };

        document.addEventListener('DOMContentLoaded', function() {
            initMap();
            loadMarkers();

            // Handle Seleksi dari Sidebar Livewire
            if (typeof Livewire !== 'undefined') {
                Livewire.on('location-selected', (eventData) => {
                    const data = Array.isArray(eventData) ? eventData[0] : eventData;
                    if (!data.lat || !data.lng) return;

                    let foundObject = null;
                    let singularType = '';

                    // Cari Object berdasarkan Tab yang aktif
                    if (data.type === 'regions') {
                        foundObject = mapData.regions.find(item => item.id === data.id);
                        singularType = 'region';
                    } else if (data.type === 'stations') {
                        foundObject = mapData.stations.find(item => item.id === data.id);
                        singularType = 'station';
                    } else if (data.type === 'facilities') {
                        foundObject = mapData.facilities.find(item => item.id === data.id);
                        singularType = 'facility';
                    } else if (data.type === 'reports') {
                        foundObject = mapData.reports.find(item => item.id === data.id);
                        singularType = 'report';
                    }

                    if (foundObject) {
                        openDetail(singularType, foundObject);
                        map.flyTo([data.lat, data.lng], 17, {
                            animate: true,
                            duration: 1.5
                        });
                    }
                });
            }
        });

        // --- FUNGSI INIT MAP ---
        function initMap() {
            const mapContainer = document.getElementById('map');
            if (!mapContainer) return;

            map = L.map('map', {
                zoomControl: false
            }).setView([-6.2088, 106.8456], 12);

            // Dark Map Tiles
            L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
                attribution: '&copy; CARTO',
                maxZoom: 20
            }).addTo(map);

            // Layer Controls
            const overlays = {
                "<span class='text-slate-300 font-bold ml-1'>⚠️ Wilayah</span>": layers.regions,
                "<span class='text-slate-300 font-bold ml-1'>📡 Pos Pantau</span>": layers.stations,
                "<span class='text-slate-300 font-bold ml-1'>🏥 Fasilitas</span>": layers.facilities,
                "<span class='text-slate-300 font-bold ml-1'>📢 Laporan Warga</span>": layers.reports
            };

            L.control.layers(null, overlays, {
                position: 'topleft',
                collapsed: false
            }).addTo(map);

            // Add All Layers Default
            layers.regions.addTo(map);
            layers.stations.addTo(map);
            layers.facilities.addTo(map);
            layers.reports.addTo(map);
        }

        // --- LOAD MARKERS ---
        function loadMarkers() {
            // 1. Regions
            mapData.regions.forEach(item => {
                if (item.lat && item.lng) {
                    const color = getStatusColor(item.status);
                    const marker = L.marker([item.lat, item.lng], {
                            icon: createCustomIcon('flood', color)
                        })
                        .bindPopup(
                            `<b class="text-sm">${item.name}</b><br><span class="text-xs text-gray-400">Status: ${item.status}</span>`
                        )
                        .on('click', () => openDetail('region', item));
                    layers.regions.addLayer(marker);
                }
            });

            // 2. Stations
            mapData.stations.forEach(item => {
                if (item.lat && item.lng) {
                    const color = getStatusColor(item.status);
                    const marker = L.marker([item.lat, item.lng], {
                            icon: createCustomIcon('water_drop', color, 'square')
                        })
                        .bindPopup(
                            `<b class="text-sm">${item.name}</b><br><span class="text-xs text-blue-300">Tinggi Air: ${item.water_level} cm</span>`
                        )
                        .on('click', () => openDetail('station', item));
                    layers.stations.addLayer(marker);
                }
            });

            // 3. Facilities
            mapData.facilities.forEach(item => {
                if (item.lat && item.lng) {
                    let color = item.status === 'buka' ? 'emerald' : (item.status === 'penuh' ? 'amber' : 'slate');
                    let iconName = 'domain';
                    if (item.facility_type === 'posko_kesehatan') iconName = 'medical_services';
                    if (item.facility_type === 'dapur_umum') iconName = 'restaurant';
                    if (item.facility_type === 'pengungsian') iconName = 'night_shelter';

                    const marker = L.marker([item.lat, item.lng], {
                            icon: createCustomIcon(iconName, color, 'circle-solid')
                        })
                        .bindPopup(`<b class="text-sm">${item.name}</b>`)
                        .on('click', () => openDetail('facility', item));
                    layers.facilities.addLayer(marker);
                }
            });

            // 4. Public Reports (Laporan Masyarakat)
            if (mapData.reports) {
                mapData.reports.forEach(item => {
                    if (item.lat && item.lng) {
                        let color = 'yellow'; // pending
                        let iconName = 'priority_high';
                        let animate = false;

                        if (item.status === 'diproses') {
                            color = 'blue';
                            iconName = 'engineering';
                        }
                        if (item.status === 'emergency') {
                            color = 'red';
                            iconName = 'sos';
                            animate = true;
                        }

                        const marker = L.marker([item.lat, item.lng], {
                                icon: createCustomIcon(iconName, color, 'report', animate)
                            })
                            .bindPopup(
                                `<b class="text-sm">Laporan: ${item.code}</b><br><span class="text-xs text-gray-400 capitalize">${item.status}</span>`
                            )
                            .on('click', () => openDetail('report', item));
                        layers.reports.addLayer(marker);
                    }
                });
            }
        }

        // --- CREATE ICON ---
        function createCustomIcon(symbol, colorName, shape = 'circle', animate = false) {
            let shapeClass = 'rounded-full';
            let borderClass = 'border-2 border-white/90';

            if (shape === 'square') shapeClass = 'rounded-xl';
            if (shape === 'report') shapeClass =
                'rounded-tr-none rounded-bl-none rounded-tl-lg rounded-br-lg'; // Bentuk Diamond/Unik

            // Tailwind Safe Colors Mapping (Pastikan class ini ada di safelist config tailwind jika tidak muncul)
            // Disini saya inject class dinamis. Jika icon tidak berwarna, ganti 'bg-${colorName}-600' dengan style hex manual.

            const animationClass = animate ? 'animate-ping' : '';

            const html = `
                <div class="relative flex items-center justify-center size-10 cursor-pointer hover:scale-110 transition-transform duration-300 group">
                    <span class="absolute inline-flex h-full w-full ${shapeClass} bg-${colorName}-500 opacity-40 ${animationClass}"></span>
                    <span class="absolute inline-flex h-full w-full ${shapeClass} bg-${colorName}-500 opacity-20 group-hover:animate-ping"></span>
                    <div class="relative inline-flex ${shapeClass} h-9 w-9 bg-${colorName}-600 ${borderClass} shadow-lg items-center justify-center group-hover:bg-${colorName}-500 transition-colors">
                        <span class="material-symbols-outlined text-white text-[18px] drop-shadow-sm">${symbol}</span>
                    </div>
                    <div class="absolute -bottom-1 w-2 h-2 bg-${colorName}-600 rotate-45"></div>
                </div>
            `.trim();

            return L.divIcon({
                className: 'bg-transparent border-none',
                html: html,
                iconSize: [40, 48],
                iconAnchor: [20, 48],
                popupAnchor: [0, -45]
            });
        }

        // --- OPEN DETAIL CARD ---
        function openDetail(type, data) {
            const card = document.getElementById('detail-card');
            const badge = document.getElementById('detail-badge');
            const editLink = document.getElementById('detail-edit-link');

            // 1. Header Logic
            let color = 'slate';
            let labelType = type.toUpperCase();
            let titleText = data.name || data.code; // Station/Region punya name, Report punya code

            if (type === 'region') {
                color = getStatusColor(data.status);
                labelType = "WILAYAH BANJIR";
                editLink.href = `{{ url('regions') }}/${data.id}/edit`;
                editLink.textContent = "Edit Wilayah";
            } else if (type === 'station') {
                color = 'blue';
                labelType = "SENSOR AIR";
                editLink.href = `{{ url('stations') }}/${data.id}/edit`;
                editLink.textContent = "Edit Pos Pantau";
            } else if (type === 'facility') {
                color = 'purple';
                labelType = "FASILITAS";
                editLink.href = `{{ url('disaster-facilities') }}/${data.id}/edit`;
                editLink.textContent = "Edit Fasilitas";
            } else if (type === 'report') {
                color = data.status === 'emergency' ? 'red' : (data.status === 'diproses' ? 'blue' : 'yellow');
                labelType = "LAPORAN WARGA";
                editLink.href = `{{ url('public-reports') }}/${data.id}`; // URL ke detail laporan
                editLink.textContent = "Proses Laporan";
            }

            document.getElementById('detail-title').textContent = titleText;
            badge.className =
                `inline-flex items-center gap-1 px-2.5 py-0.5 rounded text-[10px] font-bold bg-${color}-500 text-white mb-2 uppercase tracking-wide`;
            badge.textContent = labelType;

            // 2. Body Content Logic
            const body = document.getElementById('detail-body');
            let contentHtml = '';

            // Layout Khusus Laporan
            if (type === 'report') {
                contentHtml = `
                    <div class="mb-4">
                        <div class="flex items-center justify-between bg-black/20 p-3 rounded-xl border border-white/5 mb-3">
                            <span class="text-xs text-slate-400">Pelapor</span>
                            <span class="text-sm font-bold text-white flex items-center gap-1">
                                <span class="material-symbols-outlined text-sm">person</span> ${data.reporter_name}
                            </span>
                        </div>
                        <div class="flex gap-2 mb-4">
                            <div class="flex-1 bg-blue-500/10 border border-blue-500/20 p-3 rounded-xl text-center">
                                <span class="block text-[10px] uppercase text-blue-300 mb-1">Tinggi Air</span>
                                <span class="block text-xl font-black text-white">${data.water_level} cm</span>
                            </div>
                            <div class="flex-1 bg-${color}-500/10 border border-${color}-500/20 p-3 rounded-xl text-center">
                                <span class="block text-[10px] uppercase text-${color}-300 mb-1">Status</span>
                                <span class="block text-xl font-black text-white uppercase tracking-tight">${data.status}</span>
                            </div>
                        </div>

                        <div class="mb-4">
                            <h5 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Lokasi & Catatan</h5>
                            <p class="text-sm text-slate-200 bg-white/5 p-3 rounded-xl border border-white/5 mb-2">${data.location}</p>
                            <p class="text-sm text-slate-300 italic">"${data.note || 'Tidak ada catatan tambahan.'}"</p>
                        </div>

                        ${data.photo ? `
                                                                        <div class="mb-2">
                                                                            <h5 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Foto Lapangan</h5>
                                                                            <div class="rounded-xl overflow-hidden border border-white/10 group cursor-pointer">
                                                                                <img src="/storage/${data.photo}" class="w-full h-40 object-cover hover:scale-105 transition-transform duration-500">
                                                                            </div>
                                                                        </div>
                                                                    ` : ''}

                        <div class="text-[10px] text-center text-slate-500 mt-4 flex items-center justify-center gap-1">
                            <span class="material-symbols-outlined text-[12px]">schedule</span> Dilaporkan ${data.time_ago}
                        </div>
                    </div>
                `;
            } else {
                // Layout Umum (Region, Station, Facility)
                // ... (Gunakan layout dari kode sebelumnya) ...
                contentHtml += `
                    <div class="grid grid-cols-2 gap-3 mb-5">
                        <div class="bg-black/20 p-3 rounded-xl border border-white/5 flex flex-col">
                            <span class="text-slate-400 text-[10px] uppercase tracking-wider mb-1">Latitude</span>
                            <span class="text-white font-mono text-sm">${parseFloat(data.lat).toFixed(6)}</span>
                        </div>
                        <div class="bg-black/20 p-3 rounded-xl border border-white/5 flex flex-col">
                            <span class="text-slate-400 text-[10px] uppercase tracking-wider mb-1">Longitude</span>
                            <span class="text-white font-mono text-sm">${parseFloat(data.lng).toFixed(6)}</span>
                        </div>
                    </div>
                `;

                if (type === 'region') {
                    const statusColor = getStatusColor(data.status);
                    contentHtml += `
                        <div class="mb-5 bg-${statusColor}-500/10 border border-${statusColor}-500/20 p-4 rounded-xl flex items-center gap-4">
                            <div class="p-3 bg-${statusColor}-500/20 rounded-full text-${statusColor}-400">
                                <span class="material-symbols-outlined text-2xl">warning</span>
                            </div>
                            <div>
                                <span class="block text-${statusColor}-200 text-xs mb-0.5">Status Saat Ini</span>
                                <span class="block text-white font-bold text-lg uppercase tracking-wide">${data.status}</span>
                            </div>
                        </div>
                        <div class="mb-5">
                            <h5 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Catatan Risiko</h5>
                            <p class="text-sm text-slate-300 bg-white/5 p-4 rounded-xl border border-white/5 leading-relaxed">${data.note || '-'}</p>
                        </div>
                        <div>
                            <h5 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Dipantau Oleh</h5>
                            <div class="text-sm text-blue-300 bg-blue-500/10 p-3 rounded-lg border border-blue-500/20">${data.influenced_by || 'Belum terhubung'}</div>
                        </div>
                    `;
                } else if (type === 'station') {
                    contentHtml += `
                        <div class="flex items-center justify-between mb-5 p-5 bg-gradient-to-br from-blue-600/20 to-blue-900/20 border border-blue-500/30 rounded-2xl relative overflow-hidden">
                            <div class="absolute right-0 top-0 p-4 opacity-10"><span class="material-symbols-outlined text-6xl">water_drop</span></div>
                            <div class="relative z-10">
                                <span class="text-blue-200 text-xs font-bold uppercase mb-1 block">Tinggi Air</span>
                                <div class="flex items-baseline gap-1"><span class="text-4xl font-black text-white">${data.water_level}</span><span class="text-sm font-medium text-blue-200">cm</span></div>
                            </div>
                            <div class="relative z-10 text-right"><span class="inline-block px-3 py-1 rounded-full bg-slate-900/50 backdrop-blur-sm border border-white/10 text-xs font-bold text-white uppercase tracking-wide">${data.status}</span></div>
                        </div>
                        <div class="mb-4">
                            <h5 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Lokasi Fisik</h5>
                            <p class="text-sm text-slate-300 pl-1 border-l-2 border-slate-600">${data.location}</p>
                        </div>
                    `;
                } else if (type === 'facility') {
                    contentHtml += `
                        <div class="flex gap-3 mb-5">
                            <span class="px-3 py-1.5 rounded-lg bg-white/10 text-xs font-medium text-white border border-white/10 capitalize">${data.facility_type.replace('_', ' ')}</span>
                            <span class="px-3 py-1.5 rounded-lg text-xs font-bold uppercase border bg-white/5 text-white">${data.status}</span>
                        </div>
                        <div class="mb-4">
                            <h5 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Alamat Lengkap</h5>
                            <p class="text-sm text-slate-300 bg-white/5 p-4 rounded-xl border border-white/5">${data.address}</p>
                        </div>
                    `;
                }
            }

            body.innerHTML = contentHtml;
            card.classList.remove('slide-out');
            card.classList.add('slide-in');
        }

        function closeDetailCard() {
            const card = document.getElementById('detail-card');
            card.classList.remove('slide-in');
            card.classList.add('slide-out');
        }

        function resetMap() {
            if (map) {
                map.flyTo([-6.2088, 106.8456], 12);
                closeDetailCard();
            }
        }

        function getStatusColor(status) {
            status = status.toLowerCase();
            if (status === 'awas') return 'red';
            if (status === 'siaga') return 'amber';
            return 'emerald';
        }
    </script>
@endsection
