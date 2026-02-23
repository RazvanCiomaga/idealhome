<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Services\ImobManager as ImobManagerService;
use Illuminate\Console\Command;
use Illuminate\Foundation\Bus\Dispatchable;

class SyncAgents extends Command
{
    use Dispatchable;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sync-agents';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync agents data from imobmanager.';

    /**
     * The ImobManagerService instance.
     *
     * @var ImobManagerService
     */
    protected ImobManagerService $imobManagerService;

    /**
     * Create a new command instance.
     *
     * @param ImobManagerService $imobManagerService
     */
    public function __construct(ImobManagerService $imobManagerService)
    {
        parent::__construct();
        $this->imobManagerService = $imobManagerService;
    }

    /**
     * old crm.
     */
    public function handle()
    {
        try {
            $imobManagerAgencyId = config('services.imobmanager.id');

            $agents = $this->imobManagerService->get("agency/{$imobManagerAgencyId}/agent");
            $this->createOrUpdateAgents($agents);
        } catch (\Exception $e) {
            return 1;
        }

        return 0;
    }

    /**
     * Create or update agents in the database based on provided data.
     *
     * This method iterates over an array of agents and uses the updateOrCreate
     * method to either update existing agents or create new ones based on their
     * unique external ID (imobmanager_id).
     *
     * @param array $agents An array of agent data fetched from an external source.
     */
    protected function createOrUpdateAgents(array $agents): void
    {
        foreach ($agents['data'] ?? [] as $agentData) {
            User::query()->updateOrCreate(
                ['imobmanager_id' => $agentData['id']], // Identify agents by their unique external ID
                [
                    'name' => $agentData['name'] ?? null,
                    'email' => $agentData['email'] ?? null,
                    'phone' => $agentData['phone'] ?? null,
                    'position' => $agentData['position'] ?? null,
                    'agency_id' => $agentData['agency_id'] ?? null,
                    'description' => $agentData['description'] ?? null,
                    'picture' => $agentData['picture'] ?? null,
                    'password' => env('FILAMENT_BASE_PASSWORD'),
                ]
            );
        }
    }
}
