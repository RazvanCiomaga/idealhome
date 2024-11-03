<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Agent
 *
 * @property int|null $imobmanager_id
 * @property string|null $name
 * @property string|null $email
 * @property string|null $phone
 * @property string|null $position
 * @property int|null $agency_id
 * @property string|null $description
 * @property string|null $picture
 */
class Agent extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];
}
