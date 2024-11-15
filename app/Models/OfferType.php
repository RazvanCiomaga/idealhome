<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OfferType
 *
 * @property int|null $imobmanager_id
 * @property string|null $name
 */
class OfferType extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];
}
