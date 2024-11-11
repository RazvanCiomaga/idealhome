<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PossibleClient extends Model
{
    protected $table = 'possible_clients';
    protected $guarded = ['id'];

    public function estates(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Estate::class, 'estate_possible_client');
    }
}
