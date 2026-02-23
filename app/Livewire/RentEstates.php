<?php

namespace App\Livewire;

use App\Models\Estate;
use App\Models\EstateType;
use App\Models\RoomEntrance;
use App\Models\Zone;
use Livewire\Component;
use Livewire\WithPagination;

class RentEstates extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';


    public array $filters = [];
    public string $defaultSelect = 'none';

    public string $roomEntrance = 'none';

    public string $zone = 'none';

    public $year = '';

    public $floor = 'none';
    public $rooms = 'none';

    public $title = '';

    public $offerType = 2;

    public $searchTerm = '';

    public $estateType = 'none';

    public $sortOption = 'published_date_desc'; // Default sorting option

    public $sortOptions = [];

    protected $queryString = [
        'roomEntrance',
        'zone',
        'year',
        'floor',
        'estateType',
        'rooms',
    ];

    public function mount(): void
    {
        $this->filters = $this->getFilters();
        $this->defaultSelect = 'none';
        // Initialize properties using query string if available, otherwise use defaults
        $this->roomEntrance = request()->query('roomEntrance', 'none');
        $this->zone = request()->query('zone', 'none');
        $this->year = request()->query('year', '');
        $this->floor = request()->query('floor', 'none');
        $this->estateType = request()->query('estateType', 'none');
        $this->rooms = request()->query('rooms', 'none');
        $this->title = label('Proprietati de inchiriat');

        // Define sorting options using the custom label() translation function
        $this->sortOptions = [
            'published_date_desc' => label('Data publicării (Recente)'),
            'published_date_asc' => label('Data publicării (Vechi)'),
            'usable_area_desc' => label('Suprafață utilă (Mare)'),
            'usable_area_asc' => label('Suprafață utilă (Mică)'),
        ];

        if ($this->offerType == 1) { // Sale
            $this->sortOptions['sale_price_desc'] = label('Preț (Mare la Mic)');
            $this->sortOptions['sale_price_asc'] = label('Preț (Mic la Mare)');
        } elseif ($this->offerType == 2) { // Rent
            $this->sortOptions['rent_price_desc'] = label('Preț (Mare la Mic)');
            $this->sortOptions['rent_price_asc'] = label('Preț (Mic la Mare)');
        }
    }

    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
        return view('livewire.rent-estates');
    }

    public function getEstates(): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return Estate::query()
            ->forListingCard()
            ->when($this->offerType, function ($query) {
                if ($this->offerType == 1) { // Sale
                    $query->where('sale_price', '>', 0);
                } elseif ($this->offerType == 2) { // Rent
                    $query->where('rent_price', '>', 0);
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
            ->when($this->rooms !== $this->defaultSelect, fn($query) => $query->where('rooms', '=', $this->rooms))
            ->when($this->estateType !== $this->defaultSelect, fn($query) => $query->where('estate_type_id', '=', $this->estateType))
            ->when($this->searchTerm, function ($query) {
                $query->where(function ($query) {
                    $query->whereRaw('LOWER(title) like ?', ['%' . strtolower($this->searchTerm) . '%'])
                        ->orWhereRaw('LOWER(description) like ?', ['%' . strtolower($this->searchTerm) . '%']);
                });
            })
            ->when($this->sortOption !== $this->defaultSelect, function ($query) {
                $lastUnderscorePos = strrpos($this->sortOption, '_'); // Find the last underscore
                $column = substr($this->sortOption, 0, $lastUnderscorePos); // Extract column name
                $direction = substr($this->sortOption, $lastUnderscorePos + 1); // Extract direction

                $query->orderBy($column, $direction);
            })
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
        $this->rooms = $this->defaultSelect;
        $this->resetPage();
    }

    public function updatedSearchTerm(): void
    {
        $this->resetPage();
    }

    public function updatedSortOption(): void
    {
        $this->resetPage();
    }

    public function getFilters(): array
    {
        return [
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
            'estateTypes' => EstateType::query()->orderBy('name')->get()->pluck('name', 'id')->toArray(),
            'rooms' => [
                1 => 1,
                2 => 2,
                3 => 3,
                4 => 4,
                5 => 5,
                6 => 6,
            ],
        ];
    }
}
