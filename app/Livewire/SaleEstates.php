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

    public $floor = 'none';

    public $title = '';

    public $type = 'sale';

    protected $queryString = [
        'roomEntrance',
        'zone',
        'year',
        'floor'
    ];

    public function mount(): void
    {
        // Initialize properties using query string if available, otherwise use defaults
        $this->roomEntrance = request()->query('roomEntrance', 'none');
        $this->zone = request()->query('zone', 'none');
        $this->year = request()->query('year', '');
        $this->floor = request()->query('floor', 'none');
        $this->title = label('Proprietati de vanzare');
    }

    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
        return view('livewire.sale-estates', [
            'estates' => $this->getEstates(),
            'defaultSelect' => $this->defaultSelect,
            'filters' => [
                'roomEntrances' => RoomEntrance::query()->orderBy('name')->get()->pluck('name', 'name')->toArray(),
                'zones' => Zone::query()->orderBy('name')->get()->pluck('name', 'name')->toArray(),
                'construction_year' => [
                    'before' => label('Inainte de 1977'),
                    'after' => label('Dupa 1977'),
                ],
                'floors' => [
                    'Parter' => label('Parter'),
                    1 => 1,
                    2 => 2,
                    3 => 3,
                    4 => 4,
                    5 => 5,
                    6 => 6,
                    7 => 7,
                    8 => 8,
                    9 => 9,
                    10 => 10,
                ],
            ],
        ]);
    }

    public function getEstates(): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return Estate::query()
            ->when($this->type, function ($query) {
                if ($this->type === 'sale') {
                    $query->where('sale_price', '>', 0)
                        ->where('rent_price', '=', 0);
                } elseif ($this->type === 'rent') {
                    $query->where('sale_price', '=', 0)
                        ->where('rent_price', '>', 0);
                }
            })
            ->when($this->roomEntrance !== $this->defaultSelect, fn($query) => $query->where('room_entrances', '=', $this->roomEntrance))
            ->when($this->zone !== $this->defaultSelect, fn($query) => $query->where('zone', '=', $this->zone))
            ->when($this->year, function ($query) {
                if ($this->year === 'before') {
                    $query->where('construction_year', '<', 1977);
                } elseif ($this->year === 'after') {
                    $query->where('construction_year', '>=', 1977);
                }
            })
            ->when($this->floor !== $this->defaultSelect, fn($query) => $query->where('floor', '=', $this->floor))
            ->orderBy('published_date', 'desc')
            ->paginate(12);
    }

    public function applyFilters(): void
    {
        $this->resetPage();
    }
}
