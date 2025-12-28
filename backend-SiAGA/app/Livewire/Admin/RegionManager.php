<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Region;

class RegionManager extends Component
{
    use WithPagination;

    // Properti Filter
    public $search = '';
    public $statusFilter = '';

    // Properti Detail Card
    public $selectedRegionId = null;

    // Reset pagination saat search berubah
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function selectRegion($id)
    {
        $this->selectedRegionId = $id;
        // Dispatch event ke JavaScript (untuk Peta Leaflet agar FlyTo)
        $region = Region::find($id);
        if ($region) {
            $this->dispatch('region-selected', lat: $region->latitude, lng: $region->longitude);
        }
    }

    public function setFilter($status)
    {
        $this->statusFilter = $status;
        $this->resetPage();
    }

    public function render()
    {
        $query = Region::query()
            ->when($this->search, function ($q) {
                $q->where('name', 'like', "%{$this->search}%")
                    ->orWhere('location', 'like', "%{$this->search}%");
            })
            ->when($this->statusFilter, function ($q) {
                $q->where('flood_status', $this->statusFilter);
            });

        // Data List
        $regions = $query->latest()->paginate(10);

        // Data Detail (Jika ada yang dipilih)
        $selectedRegion = $this->selectedRegionId
            ? Region::with('relatedStations')->find($this->selectedRegionId)
            : null;

        // Statistik (Opsional, hitung sekali saja atau cache)
        $stats = [
            'all' => Region::count(),
            'awas' => Region::where('flood_status', 'awas')->count(),
            'siaga' => Region::where('flood_status', 'siaga')->count(),
            'normal' => Region::where('flood_status', 'normal')->count(),
        ];

        return view('livewire.admin.region-manager', [
            'regions' => $regions,
            'selectedRegion' => $selectedRegion,
            'stats' => $stats
        ]);
    }
}
