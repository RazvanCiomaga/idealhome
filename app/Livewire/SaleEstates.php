<?php

namespace App\Livewire;

use App\Models\Estate;
use Illuminate\Support\Collection;
use Livewire\Component;
use Livewire\WithPagination;

class SaleEstates extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.sale-estates', [
            'estates' => $this->getEstates(),
        ]);
    }

    public function getEstates(): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return Estate::query()
            ->where('sale_price', '>', 0)
            ->where('rent_price', '=', 0)
            ->paginate(12);
    }
}
