<?php

namespace App\Livewire;

use App\Models\Estate;
use App\Models\RoomEntrance;
use App\Models\Zone;
use Livewire\Component;
use Livewire\WithPagination;

class SaleEstates extends Component
{
    use WithPagination;

    public string $defaultSelect = 'none';

    public string $roomEntrance = 'none';

    public string $zone = 'none';

    public $year = '';

    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
        return view('livewire.sale-estates', [
            'estates' => $this->getEstates(),
            'defaultSelect' => $this->defaultSelect,
            'filters' => [
                'roomEntrances' => RoomEntrance::query()->orderBy('name')->get()->pluck('name', 'name')->toArray(),
                'zones' => Zone::query()->orderBy('name')->get()->pluck('name', 'name')->toArray(),
                'construction_year' => [
                    'before' => 'Before 1977',
                    'after' => 'After 1977',
                ]
            ],
        ]);
    }

    public function getEstates(): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return Estate::query()
            ->where('sale_price', '>', 0)
            ->where('rent_price', '=', 0)
            ->when($this->roomEntrance !== $this->defaultSelect, fn($query) => $query->where('room_entrances', '=', $this->roomEntrance))
            ->when($this->zone !== $this->defaultSelect, fn($query) => $query->where('zone', '=', $this->zone))
            ->when($this->year, function ($query) {
                if ($this->year === 'before') {
                    $query->where('construction_year', '<', 1977);
                } elseif ($this->year === 'after') {
                    $query->where('construction_year', '>=', 1977);
                }
            })
            ->paginate(12);
    }

    public function applyFilters(): void
    {
        $this->resetPage();
    }
}
