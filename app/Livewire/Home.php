<?php

namespace App\Livewire;

use App\Models\EstateType;
use App\Models\OfferType;
use App\Models\RoomEntrance;
use App\Models\Zone;
use Livewire\Component;

class Home extends Component
{
    public string $defaultSelect = 'none';

    public string $roomEntrance = 'none';

    public string $zone = 'none';

    public $year = '';

    public $floor = 'none';


    public $offerType = 1;

    public string $constructionYear = 'none';

    public  array $filters = [];

    public $estateType = 'none';

    public $featuredProperties;

    public function mount(): void
    {
        $this->getFilters();
        $this->featuredProperties = \App\Models\Estate::query()->orderBy('sale_price', 'desc')->limit(3)->get();
    }

    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
        return view('livewire.home');
    }

    public function getFilters(): void
    {
        $this->filters = [
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
            'offerTypes' => OfferType::query()->orderBy('name')->get()->pluck('name', 'imobmanager_id')->toArray(),
        ];
    }

    public function applyFilters()
    {
        if ($this->offerType === 1) {
            return redirect()->route('sales-listings', [
                'roomEntrance' => $this->roomEntrance,
                'zone' => $this->zone,
                'year' => $this->year,
                'floor' => $this->floor,
                'estateType' => $this->estateType,
            ]);
        } else {
            return redirect()->route('rent-listings', [
                'roomEntrance' => $this->roomEntrance,
                'zone' => $this->zone,
                'year' => $this->year,
                'floor' => $this->floor,
                'estateType' => $this->estateType,
            ]);
        }
    }
}
