<?php

namespace App\Livewire;

use App\Models\Estate;
use App\Models\RoomEntrance;
use Illuminate\Support\Collection;
use Livewire\Component;
use Livewire\WithPagination;

class SaleEstates extends Component
{
    use WithPagination;

    public $roomEntrance = '';

    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
        return view('livewire.sale-estates', [
            'estates' => $this->getEstates(),
            'filters' => [
                'roomEntrances' => RoomEntrance::query()->get()->pluck('name', 'name')->toArray(),
            ],
        ]);
    }

    public function getEstates(): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return Estate::query()
            ->where('sale_price', '>', 0)
            ->where('rent_price', '=', 0)
            ->when($this->roomEntrance, fn($query) => $query->where('room_entrances', '=', $this->roomEntrance))
            ->paginate(12);
    }

    public function applyFilters(): void
    {
        $this->resetPage();
    }
}
