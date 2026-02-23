<?php

namespace App\Console\Commands;

use App\Models\Agency;
use App\Models\County;
use App\Models\Estate;
use App\Models\RoomEntrance;
use App\Models\User;
use App\Models\Zone;
use App\Services\ImobManager as ImobManagerService;
use Illuminate\Console\Command;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Str;

class SyncLatestEstates extends Command
{
    use Dispatchable;

    protected $signature = 'app:sync-latest-estates';
    protected $description = 'Sync latest estates from ImobManager.';
    protected ImobManagerService $imobManager;

    public function __construct(ImobManagerService $imobManager)
    {
        parent::__construct();
        $this->imobManager = $imobManager;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        try {
            $response = $this->imobManager->get("agency/6313/estate/latest");

            if (!empty($response['data'])) {
                foreach ($response['data'] as $estate) {
                    $this->createOrUpdateEstate($estate);
                }
            }
        } catch (\Exception $e) {
            // Provide a simplified error message without exposing details
            return 1; // Indicate failure
        }

        return 0; // Indicate success
    }

    protected function createOrUpdateEstate($estateData): void
    {
            // Convert price fields to integers (if needed)
            $salePrice = $estateData['sale_price'] ?? null;
            $rentPrice = $estateData['rent_price'] ?? null;

            /** @var User $agent */
            $agent = User::query()->where('imobmanager_id', $estateData['agent']['id'])->first();

            /** @var Agency $agency */
            $agency = Agency::query()->where('imobmanager_id', $estateData['agency_id'])->first();

            // Create or update the estate
            Estate::query()->updateOrCreate(
                ['imobmanager_id' => $estateData['id']], // Identify estates by their unique external ID
                [
                    'title' => $estateData['title'] ?? null,
                    'title_en' => $estateData['title_en'] ?? null,
                    'description' => $estateData['description'] ?? null,
                    'description_en' => $estateData['description_en'] ?? null,
                    'city' => $estateData['city'] ?? null,
                    'zone' => $estateData['zone'] ?? null,
                    'county' => $estateData['county'] ?? null,
                    'rooms' => $estateData['rooms'] ?? null,
                    'bathrooms' => $estateData['bathrooms'] ?? null,
                    'floor' => $estateData['floor'] ?? null,
                    'max_floor' => $estateData['max_floor'] ?? null,
                    'floor_formatted' => $estateData['floor_formatted'] ?? null,
                    'area' => $estateData['area'] ?? null,
                    'usable_area' => $estateData['usable_area'] ?? null,
                    'total_area' => $estateData['total_area'] ?? null,
                    'land_area' => $estateData['land_area'] ?? null,
                    'room_entrances' => $estateData['room_entrances'] ?? null,
                    'offer_type' => $estateData['offer_type'] ?? null,
                    'sale_price' => (int) $salePrice, // Ensure these are stored as integers
                    'rent_price' => (int) $rentPrice, // Ensure these are stored as integers
                    'rent_price_sqm' => $estateData['rent_price_sqm'] ?? null,
                    'construction_year' => $estateData['construction_year'] ?? null,
                    'energy_class' => $estateData['energy_class'] ?? null,
                    'general' => $estateData['general'] ?? null,
                    'exclusive' => $estateData['exclusive'] ?? false,
                    'comission' => $estateData['comission'] ?? null,
                    'thumb' => $estateData['thumb'] ?? null,
                    'featured_image' => $estateData['featured_image'] ?? null,
                    'images' => $estateData['images'] ?? [], // Store images as JSON
                    'latitude' => $estateData['latitude'] ?? null,
                    'longitude' => $estateData['longitude'] ?? null,
                    'agency_id' => $agency?->id ?? null,
                    'agent_id' => $agent?->id ?? null,
                    'published_date' => $estateData['publish_date'] ?? null,
                ]
            );

            if ($estateData['zone']) {
                $zone = Zone::query()->where('name', $estateData['zone'])->first();
                if (!$zone) {
                    Zone::query()->create(['name' => $estateData['zone']]);
                }
            }

            if ($estateData['county']) {
                $county = County::query()->where('name', $estateData['county'])->first();
                if (!$county) {
                    County::query()->create(['name' => $estateData['county']]);
                }
            }

            if ($estateData['room_entrances']) {
                $roomEntrance = RoomEntrance::query()->where('name', $estateData['room_entrances'])->first();
                if (!$roomEntrance) {
                    RoomEntrance::query()->create(['name' => $estateData['room_entrances']]);
                }
            }
    }
}
