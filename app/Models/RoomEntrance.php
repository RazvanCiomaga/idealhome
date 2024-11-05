<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RoomEntrance
 *
 * @property string|null $name
 */
class RoomEntrance extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
}
