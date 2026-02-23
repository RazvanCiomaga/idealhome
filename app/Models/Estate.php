<?php

namespace App\Models;

use App\Casts\MoneyCast;
use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

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
 * @property int|null $comission
 * @property string|null $thumb
 * @property string|null $featured_image
 * @property array|null $images
 * @property float|null $latitude
 * @property float|null $longitude
 * @property int|null $agency_id
 * @property DateTime|null $published_date
 * @property string|null $slug
 * @property array|null $estate_properties
 * @property int|null $offer_type_id
 * @property int|null $estate_type_id
 */
class Estate extends Model
{
    use HasSlug;

    protected $guarded = ['id'];

    protected $casts = [
        'images' => 'array',
        'sale_price' => MoneyCast::class,
        'rent_price' => MoneyCast::class,
        'rent_price_sqm' => MoneyCast::class,
        'comission' => MoneyCast::class,
        'estate_properties' => 'array',
    ];

    protected $appends = ['carousel_images'];

    protected static function boot()
    {
        parent::boot();

        // Set the published_date only when creating a new record
        static::creating(function ($model) {
            $model->published_date = now();
        });

    }

    /**
     * Scope a query to only include columns necessary for listing cards.
     */
    public function scopeForListingCard($query)
    {
        return $query->select([
            'id',
            'title',
            'slug',
            'featured_image',
            'sale_price',
            'rent_price',
            'construction_year',
            'room_entrances',
            'zone',
            'description',
            'bathrooms',
            'rooms',
            'area'
        ]);
    }

    public function agent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'agent_id', 'id');
    }

    public function properties(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Property::class, 'estate_property');
    }

    public function possibleClients(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(PossibleClient::class, 'estate_possible_client');
    }

    public function getFormattedProperties(): ?array
    {
        $props = [];

        if (!empty($this->estate_properties)) {
            $props = $this->estate_properties;
        }

        if ($this->properties->count() > 0) {
            $props = array_merge($props, $this->properties->pluck('name')->toArray());
        }

        return array_unique($props);
    }

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function getCarouselImagesAttribute(): array
    {
        $images = $this->images ?? [];

        return (count($images) === 1) ? [$images[0], $images[0]] : $images;
    }
}
