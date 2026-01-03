<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Region;
use App\Models\Station;
use App\Models\DisasterFacility;
use App\Models\PublicReport;

class MapSidebar extends Component
{
    use WithPagination;

    public $search = '';
    public $activeTab = 'regions'; // regions, stations, facilities
    public $statusFilter = '';
    public $selectedId = null;

    // Reset pagination saat search/tab berubah
    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function updatingActiveTab()
    {
        $this->resetPage();
        $this->statusFilter = ''; // Reset filter saat ganti tab
        $this->selectedId = null;
    }

    public function setFilter($status)
    {
        $this->statusFilter = ($this->statusFilter === $status) ? '' : $status;
        $this->resetPage();
    }

    public function render()
    {
        $items = [];
        $stats = [];

        if ($this->activeTab === 'regions') {
            $query = Region::query()
                ->where('name', 'like', '%' . $this->search . '%');

            if ($this->statusFilter) {
                $query->where('flood_status', $this->statusFilter);
            }

            $items = $query->latest()->paginate(10);

            // Hitung Stats
            $stats['all'] = Region::count();
            $stats['awas'] = Region::where('flood_status', 'awas')->count();
            $stats['siaga'] = Region::where('flood_status', 'siaga')->count();
            $stats['normal'] = Region::where('flood_status', 'normal')->count();
        } elseif ($this->activeTab === 'stations') {
            $query = Station::query()
                ->where('name', 'like', '%' . $this->search . '%');

            if ($this->statusFilter) {
                $query->where('status', $this->statusFilter);
            }

            $items = $query->latest()->paginate(10);

            $stats['all'] = Station::count();
            $stats['awas'] = Station::where('status', 'awas')->count();
            $stats['siaga'] = Station::where('status', 'siaga')->count();
            $stats['normal'] = Station::where('status', 'normal')->count();
        } elseif ($this->activeTab === 'facilities') {
            $query = DisasterFacility::query()
                ->where('name', 'like', '%' . $this->search . '%');

            if ($this->statusFilter) {
                $query->where('status', $this->statusFilter);
            }

            $items = $query->latest()->paginate(10);

            $stats['all'] = DisasterFacility::count();
            $stats['buka'] = DisasterFacility::where('status', 'buka')->count();
            $stats['penuh'] = DisasterFacility::where('status', 'penuh')->count();
            $stats['tutup'] = DisasterFacility::where('status', 'tutup')->count();
        } elseif ($this->activeTab === 'reports') {
            $query = PublicReport::query()
                ->with('user')
                // Filter status aktif saja
                ->whereIn('status', ['pending', 'diproses', 'emergency'])
                ->where(function ($q) {
                    $q->where('report_code', 'like', '%' . $this->search . '%')
                        ->orWhere('location', 'like', '%' . $this->search . '%');
                });

            if ($this->statusFilter) {
                $query->where('status', $this->statusFilter);
            }

            $items = $query->latest()->paginate(10);

            // Hitung Stats sesuai Enum
            $stats['all'] = PublicReport::whereIn('status', ['pending', 'diproses', 'emergency'])->count();
            $stats['emergency'] = PublicReport::where('status', 'emergency')->count();
            $stats['diproses'] = PublicReport::where('status', 'diproses')->count();
            $stats['pending'] = PublicReport::where('status', 'pending')->count();
        }

        return view('livewire.admin.map-sidebar', [
            'items' => $items,
            'stats' => $stats
        ]);
    }

    // app/Livewire/Admin/MapSidebar.php

    public function selectItem($id, $lat, $lng)
    {
        $this->selectedId = $id;

        // Dispatch event ke Frontend (JavaScript)
        // Kita kirimkan 'id' dan 'type' (plural sesuai nama tab: regions, stations, facilities)
        $this->dispatch('location-selected', [
            'id' => $id,
            'lat' => $lat,
            'lng' => $lng,
            'type' => $this->activeTab // regions, stations, atau facilities
        ]);
    }
}
