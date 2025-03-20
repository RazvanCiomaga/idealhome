<?php

namespace App\Console\Commands;

use App\Models\Agency;
use App\Models\County;
use App\Models\Estate;
use App\Models\OfferType;
use App\Models\RoomEntrance;
use App\Models\User;
use App\Models\Zone;
use Illuminate\Console\Command;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Stevebauman\Purify\Facades\Purify;

class SyncCrm extends Command
{
    use Dispatchable;

    protected $signature = 'app:sync-crm';
    protected $description = 'Fetch estate data from CRM JSON URL and store it in the database';

    public function handle(): void
    {
        $url = 'https://crm.ideal-home.net/ofertepesite.json';

        $response = Http::get($url);
        if ($response->failed()) {
            $this->error('Failed to fetch JSON data.');
            return;
        }

        // Get the raw body of the response
        $rawBody = $response->getBody()->getContents();
        $cleanedBody = mb_convert_encoding($rawBody, 'UTF-8', 'UTF-8');


        $data = json_decode($cleanedBody, true);

        if (!is_array($data)) {
            $this->error('Invalid JSON format.');
            return;
        }

        // Group estates by agent email to prevent duplicate agent queries
        $groupedByAgent = collect($data)->groupBy('emailagent');


        foreach ($groupedByAgent as $email => $estates) {
            $firstEstate = $estates->first(); // Get agent details from first entry

            // Find or create the agent
            $agentName = trim("{$firstEstate['prenumeagent']} {$firstEstate['numeagent']}");

            $agent = User::query()->updateOrCreate(
                ['email' => $firstEstate['emailagent']], // Identify agents by their unique external ID
                [
                    'name' => $agentName,
                    'email' => $firstEstate['emailagent'] ?? null,
                    'phone' => $firstEstate['telefonagent'] ?? null,
                    'position' => 'Agent',
                    'agency_id' => Agency::query()->first()->id ?? null,
                    'picture' => $firstEstate['pozaagent'] ?? null,
                    'password' => env('FILAMENT_BASE_PASSWORD'),
                ]
            );

            foreach ($estates as $estateData) {
                // Convert price fields to integers
                $salePrice = $estateData['pretvanzare'] ?? null;
                $rentPrice = $estateData['pretinchiriere'] ?? null;

                // Generate unique slug
                $baseSlug = Str::slug($estateData['titlu']);
                $slug = $baseSlug;
                $counter = 1;

                while (Estate::query()->where('slug', $slug)->where('crm_id', '!=', $estateData['idintern'])->exists()) {
                    $slug = "{$baseSlug}-{$counter}";
                    $counter++;
                }

                // Convert 'optiuni' string to array
                $estateProperties = !empty($estateData['optiuni'])
                    ? explode(';', $estateData['optiuni'])
                    : [];

                // Create or update the estate
                Estate::query()->updateOrCreate(
                    ['crm_id' => $estateData['idintern']], // Unique external ID
                    [
                        'title' => $estateData['titlu'] ?? null,
                        'title_en' => $estateData['titluen'] ?? null,
                        'description' => $estateData['descriere'] ? Purify::clean($estateData['descriere']) : null, // Remove HTML
                        'description_en' => $estateData['descriereen'] ? Purify::clean($estateData['descriereen']) : null,
                        'city' => $estateData['localitatea'] ?? null,
                        'zone' => $estateData['cartierul'] ?? null,
                        'county' => $estateData['judetul'] ?? null,
                        'rooms' => $estateData['numarcamere'] ?? null,
                        'bathrooms' => $estateData['numarbai'] ?? null,
                        'floor' => $estateData['etaj'] ?? null,
                        'max_floor' => $estateData['etaje'] ?? null,
                        'area' => $estateData['suprafataconstruita'] ?? null,
                        'usable_area' => $estateData['suprafatautila'] ?? null,
                        'total_area' => $estateData['suprafataconstruita'] ?? null,
                        'land_area' => $estateData['suprafatateren'] ?? null,
                        'offer_type' => $estateData['tipoperatiune'] ? OfferType::query()->whereRaw('LOWER(name) = ?', [strtolower($estateData['tipoperatiune'])])->first()?->id : null,
                        'sale_price' => (int) $salePrice,
                        'rent_price' => (int) $rentPrice,
                        'construction_year' => $estateData['anulconstructiei'] ?? null,
                        'energy_class' => $estateData['clasaenergetica'] ?? null,
                        'exclusive' => $estateData['exclusiva'] ?? false,
                        'comission' => $estateData['comision0'] ?? null,
                        'thumb' => explode(',', $estateData['poze'])[0] ?? null, // Use first image as thumbnail
                        'featured_image' => explode(',', $estateData['poze'])[0] ?? null,
                        'images' => explode(',', $estateData['poze']) ?? [], // Store images as JSON array
                        'latitude' => $estateData['latitudine'] ?? null,
                        'longitude' => $estateData['longitudine'] ?? null,
                        'agency_id' => $agency?->id ?? null,
                        'agent_id' => $agent->id,
                        'slug' => $slug,
                        'estate_properties' => $estateProperties, // Store options as JSON
                    ]
                );

                // Store related zone, county, and room entrances
                if ($estateData['cartierul']) {
                    Zone::query()->firstOrCreate(['name' => $estateData['cartierul']]);
                }

                if ($estateData['judetul']) {
                    County::query()->firstOrCreate(['name' => $estateData['judetul']]);
                }

                if ($estateData['compartimentare']) {
                    RoomEntrance::query()->firstOrCreate(['name' => $estateData['compartimentare']]);
                }
            }
        }
    }
}
