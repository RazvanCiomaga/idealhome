<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
use Livewire\WithPagination;

class Agent extends Component
{
    use WithPagination;

    public User|null $agent;

    protected $paginationTheme = 'bootstrap';

    public function mount($slug): void
    {
        $this->agent = User::query()->with('estates')->where('slug', $slug)->whereRaw('LOWER(position) like ?', ['%agent%'])->first();
    }

    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
        return view('livewire.agent');
    }

    public function getEstates(): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return $this->agent?->estates()
            ->paginate(6);
    }
}
