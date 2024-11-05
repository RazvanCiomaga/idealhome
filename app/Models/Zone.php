<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Zone
 *
 * @property string|null $name
 */
class Zone extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
}
