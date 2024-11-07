<?php

namespace App\Livewire;

use App\Models\Agent;
use App\Models\Estate as EstateModel;
use Livewire\Component;

class Estate extends Component
{
    public string $slug;
    public EstateModel|null $estate;
    public Agent|null $agent;

    public function mount($slug): void
    {
        $this->slug = $slug;
        $this->estate = EstateModel::query()->where('slug', $this->slug)->first();
        $this->agent = $this->estate?->agent;
    }
    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
        return view('livewire.estate');
    }
}
