<?php

namespace App\Console\Commands;

use App\Models\Agent;
use App\Models\City;
use App\Models\County;
use App\Models\RoomEntrance;
use App\Models\Year;
use App\Models\Zone;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\Estate;
use App\Models\Agency;
use App\Services\ImobManager as ImobManagerService;

class SyncEstates extends Command
{
    protected $signature = 'app:sync-estates';
    protected $description = 'Sync estates from ImobManager.';
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
        $this->info('Fetching estates from the external API...');

        try {
            $imobManagerAgencyId = config('services.imobmanager.id');
            $allEstates = []; // Array to hold all estates

            // Step 1: Get the total count of records
            $countResponse = $this->imobManager->get("estate", [
                'count' => true, // Use the count parameter to get total number of records
            ]);

            $totalCount = $countResponse['data']['numResults'] ?? 0; // Extract the total count from the response

            $perPage = 100; // Set the items per page to 100
            $totalPages = ceil($totalCount / $perPage); // Calculate the total number of pages

            // Step 2: Fetch records page by page in pairs of 100
            for ($currentPage = 1; $currentPage <= $totalPages; $currentPage++) {
                // Fetch records for the current page
                $response = $this->imobManager->get("estate", [
                    'page' => $currentPage,
                    'per_page' => $perPage, // Specify how many records per page to fetch
                ]);

                // Assuming the response contains a 'data' array with the estate records
                if (!empty($response['data'])) {
                    // Process the records in pairs of 100
                    foreach (array_chunk($response['data'], 100) as $chunk) {
                        // Here, you can process each chunk of 100 records
                        $this->createOrUpdateEstates($chunk); // Update or create estates in the database
                        $this->info('Processed a chunk of 100 estates.'); // Log for progress
                    }
                    $allEstates = array_merge($allEstates, $response['data']); // Store all records
                } else {
                    break; // Exit loop if no data returned (though unlikely if totalCount is accurate)
                }
            }

            $this->info('Estates synced successfully. Total estates processed: ' . count($allEstates));
        } catch (\Exception $e) {
            // Provide a simplified error message without exposing details
            $this->error('Error syncing estates: ' . $e->getMessage());
            return 1; // Indicate failure
        }

        return 0; // Indicate success
    }

    /**
     * Create or update estates in the database based on provided data.
     *
     * This method iterates over an array of estates and uses the updateOrCreate
     * method to either update existing estates or create new ones based on their
     * unique external ID (imobmanager_id).
     *
     * @param array $estates An array of estate data fetched from an external source.
     */
    protected function createOrUpdateEstates(array $estates): void
    {

        // Begin transaction to handle large inserts safely
        // Loop through each estate and update or create it
        foreach ($estates as $estateData) {
            // Convert price fields to integers (if needed)
            $salePrice = $estateData['sale_price'] ?? null;
            $rentPrice = $estateData['rent_price'] ?? null;

            /** @var Agent $agent */
            $agent = Agent::query()->where('imobmanager_id', $estateData['agent']['id'])->first();

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
                ]
            );

            if ($estateData['city']) {
                $city = City::query()->where('name', $estateData['city'])->first();
                if (!$city) {
                    City::query()->create(['name' => $estateData['city']]);
                }
            }

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

            if ($estateData['construction_year']) {
                $year = Year::query()->where('name', $estateData['construction_year'])->first();
                if (!$year) {
                    Year::query()->create(['name' => $estateData['construction_year']]);
                }
            }
        }
    }
}
