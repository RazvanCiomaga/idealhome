<?php

namespace App\Models;

use App\Casts\MoneyCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class County
 *
 * @property string|null $name
 */
class County extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
}
