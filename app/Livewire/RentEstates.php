<?php

namespace App\Livewire;

use App\Models\Estate;
use App\Models\RoomEntrance;
use App\Models\Zone;
use Livewire\Component;
use Livewire\WithPagination;

class RentEstates extends SaleEstates
{
   public $type = 'rent';

   public $title = '';

   public function mount(): void
   {
       $this->title = label('Proprietati de inchiriat');
   }
}
