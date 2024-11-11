<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Agency
 *
 * @property int|null $imobmanager_id
 * @property string|null $name
 * @property string|null $email
 * @property string|null $website
 * @property string|null $cuifirma
 * @property string|null $jfirma
 * @property string|null $registry
 * @property string|null $address
 * @property string|null $phone
 * @property string|null $description
 * @property string|null $logo
 * @property string|null $weekly_hours
 * @property string|null $saturday_hours
 * @property string|null $sunday_hours
 */
class Agency extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];
}
