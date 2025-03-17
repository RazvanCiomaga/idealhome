<?php

namespace App\Livewire;

use App\Models\Agency;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class Team extends Component
{
    public Collection $agents;

    public function mount(): void
    {
        $this->agents = User::query()->whereRaw('LOWER(position) like ?', ['%agent%'])->get();
    }

    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
        return view('livewire.team');
    }
}
