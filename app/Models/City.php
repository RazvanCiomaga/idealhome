<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class City
 *
 * @property string|null $name
 */
class City extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
}
