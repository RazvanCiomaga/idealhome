<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EstateType
 *
 * @property int|null $imobmanager_id
 * @property string|null $name
 */
class EstateType extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];
}
