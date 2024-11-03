<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\Agency;
use App\Services\ImobManager as ImobManagerService;

class SyncAgencies extends Command
{
    protected $signature = 'app:sync-agencies';
    protected $description = 'Sync agencies from ImobManager.';
    protected ImobManagerService $imobManagerService;

    public function __construct(ImobManagerService $imobManagerService)
    {
        parent::__construct();
        $this->imobManagerService = $imobManagerService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        // Fetch agencies from the external API
        $this->info('Fetching agency data from imobmanager...');

        try {
            $imobManagerAgencyId = config('services.imobmanager.id');
            $agencyData = $this->imobManagerService->get("agency/{$imobManagerAgencyId}");

            Agency::query()->updateOrCreate(
                ['imobmanager_id' => $agencyData['id']], // Identify agencies by their unique external ID
                [
                    'name' => $agencyData['name'] ?? null,
                    'email' => $agencyData['email'] ?? null,
                    'website' => $agencyData['website'] ?? null,
                    'cuifirma' => $agencyData['cuifirma'] ?? null,
                    'jfirma' => $agencyData['jfirma'] ?? null,
                    'registry' => $agencyData['registry'] ?? null,
                    'address' => $agencyData['address'] ?? null,
                    'phone' => $agencyData['phone'] ?? null,
                    'description' => $agencyData['description'] ?? null,
                    'logo' => $agencyData['logo'] ?? null,
                ]
            );

            $this->info('Agency data synced successfully.');
        } catch (\Exception $e) {
            // Provide a simplified error message without exposing details
            $this->error('Error syncing agencies: ' . $e->getMessage());
            return 1; // Indicate failure
        }

        return 0; // Indicate success
    }
}
