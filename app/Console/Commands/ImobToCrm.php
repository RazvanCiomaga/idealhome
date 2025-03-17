<?php

namespace App\Console\Commands;

use App\Models\Estate;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;

class ImobToCrm extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:imob-to-crm';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Associate old imobmanager data with new crm data.';

    /**
     * Execute the console command.
     */
    public function handle()
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
        $estates = collect($data);

        foreach ($estates as $estateData) {
            $existingEstateQuery = Estate::query()
                ->where('title', $estateData['titlu']);

            if ((int) $estateData['pretvanzare'] > 0) {
                $existingEstateQuery->where('sale_price', (int) $estateData['pretvanzare'] * 100);
            }

            if ((int)$estateData['pretinchiriere'] > 0) {
                $existingEstateQuery->where('rent_price', (int) $estateData['pretinchiriere'] * 100);
            }

            if ($estateData['anulconstructiei']) {
                $existingEstateQuery->where('construction_year', Carbon::parse($estateData['anulconstructiei'])->format('Y'));
            }

            if ((int) $estateData['suprafatautila'] > 0) {
                $existingEstateQuery->where('usable_area', (int) $estateData['suprafatautila']);
            }

            if ((int) $estateData['suprafatateren'] > 0) {
                $existingEstateQuery->where('land_area', (int) $estateData['suprafatateren']);
            }

            if ((int) $estateData['numarcamere'] > 0) {
                $existingEstateQuery->where('rooms', (int) $estateData['numarcamere']);
            }

            if ((int) $estateData['numarbai'] > 0) {
                $existingEstateQuery->where('bathrooms', (int) $estateData['numarbai']);
            }

            $existingEstate = $existingEstateQuery->first();

            if ($existingEstate) {
                $existingEstate->crm_id = $estateData['idintern'];
                $existingEstate->save();
                continue;
            }
        }
    }
}
