<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Year
 *
 * @property integer|null $name
 */
class Year extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
}
