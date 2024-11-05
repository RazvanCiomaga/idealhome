<?php

namespace App\Livewire;

use App\Models\City;
use App\Models\Estate;
use App\Models\RoomEntrance;
use App\Models\Year;
use App\Models\Zone;
use Illuminate\Support\Collection;
use Livewire\Component;
use Livewire\WithPagination;

class SaleEstates extends Component
{
    use WithPagination;

    public string $roomEntrance = '';

    public string $zone = '';

    public $year = '';

    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
        return view('livewire.sale-estates', [
            'estates' => $this->getEstates(),
            'filters' => [
                'roomEntrances' => RoomEntrance::query()->orderBy('name')->get()->pluck('name', 'name')->toArray(),
                'zones' => Zone::query()->orderBy('name')->get()->pluck('name', 'name')->toArray(),
            ],
        ]);
    }

    public function getEstates(): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return Estate::query()
            ->where('sale_price', '>', 0)
            ->where('rent_price', '=', 0)
            ->when($this->roomEntrance, fn($query) => $query->where('room_entrances', '=', $this->roomEntrance))
            ->when($this->zone, fn($query) => $query->where('zone', '=', $this->zone))
            ->when($this->year, fn($query) => $query->where('construction_year', '=', $this->year))
            ->paginate(12);
    }

    public function applyFilters(): void
    {
        $this->resetPage();
    }
}
