<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class County
 *
 * @property string|null $name
 */
class EstateSync extends Model
{
    protected $table = 'estate_sync';
    protected $guarded = ['id'];
}
