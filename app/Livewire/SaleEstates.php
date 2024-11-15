<?php

namespace App\Livewire;

use App\Models\Estate;
use App\Models\EstateType;
use App\Models\RoomEntrance;
use App\Models\Zone;
use Livewire\Component;
use Livewire\WithPagination;

class SaleEstates extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public string $defaultSelect = 'none';

    public string $roomEntrance = 'none';

    public string $zone = 'none';

    public $year = '';

    public $floor = 'none';

    public $title = '';

    public $offerType = 1;

    public $searchTerm = '';

    public $estateType = 'none';

    protected $queryString = [
        'roomEntrance',
        'zone',
        'year',
        'floor',
        'estateType',
    ];

    public function mount(): void
    {
        // Initialize properties using query string if available, otherwise use defaults
        $this->roomEntrance = request()->query('roomEntrance', 'none');
        $this->zone = request()->query('zone', 'none');
        $this->year = request()->query('year', '');
        $this->floor = request()->query('floor', 'none');
        $this->estateType = request()->query('estateType', 'none');
        $this->title = label('Proprietati de vanzare');
    }

    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
        return view('livewire.sale-estates', [
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
                'estateTypes' => EstateType::query()->orderBy('name')->get()->pluck('name', 'imobmanager_id')->toArray(),
            ],
        ]);
    }

    public function getEstates(): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return Estate::query()
            ->when($this->offerType, fn($query) => $query->where('offer_type_id', '=', $this->offerType))
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
            ->when($this->estateType !== $this->defaultSelect, fn($query) => $query->where('estate_type_id', '=', $this->estateType))
            ->when($this->searchTerm, function ($query) {
                $query->where(function ($query) {
                    $query->whereRaw('LOWER(title) like ?', ['%' . strtolower($this->searchTerm) . '%'])
                        ->orWhereRaw('LOWER(description) like ?', ['%' . strtolower($this->searchTerm) . '%']);
                });
            })
            ->orderBy('published_date', 'desc')
            ->paginate(12);
    }

    public function applyFilters(): void
    {
        $this->resetPage();
    }

    public function clearFilters(): void
    {
        $this->roomEntrance = $this->defaultSelect;
        $this->zone = $this->defaultSelect;
        $this->year = '';
        $this->floor = $this->defaultSelect;
        $this->estateType = $this->defaultSelect;
        $this->resetPage();
    }

    public function updatedSearchTerm(): void
    {
        $this->resetPage();
    }
}
