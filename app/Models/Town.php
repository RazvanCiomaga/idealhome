<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Town
 *
 * @property string|null $name
 */
class Town extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
}
