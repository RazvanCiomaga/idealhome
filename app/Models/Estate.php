<?php

namespace App\Models;

use App\Casts\MoneyCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Estate
 *
 * @property int|null $imobmanager_id
 * @property string|null $title
 * @property string|null $title_en
 * @property string|null $description
 * @property string|null $description_en
 * @property string|null $city
 * @property string|null $zone
 * @property string|null $county
 * @property int|null $rooms
 * @property int|null $bathrooms
 * @property int|null $floor
 * @property string|null $max_floor
 * @property string|null $floor_formatted
 * @property int|null $area
 * @property int|null $usable_area
 * @property int|null $total_area
 * @property int|null $land_area
 * @property string|null $room_entrances
 * @property int|null $offer_type
 * @property int|null $sale_price
 * @property int|null $rent_price
 * @property int|null $rent_price_sqm
 * @property int|null $construction_year
 * @property string|null $energy_class
 * @property string|null $general
 * @property bool|null $exclusive
 * @property bool|null $comission
 * @property string|null $thumb
 * @property string|null $featured_image
 * @property array|null $images
 * @property float|null $latitude
 * @property float|null $longitude
 * @property int|null $agency_id
 */
class Estate extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'images' => 'array',
        'sale_price' => MoneyCast::class,
        'rent_price' => MoneyCast::class,
    ];
}
