<?php

namespace App\Console\Commands;

use App\Models\Estate;
use App\Models\EstateType;
use App\Models\OfferType;
use App\Services\ImobManager as ImobManagerService;
use Illuminate\Console\Command;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Client\ConnectionException;

class SyncEstatesInfo extends Command
{
    use Dispatchable;

    protected $signature = 'app:sync-estates-info';
    protected $description = 'Sync estates info from ImobManager.';
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
     * @throws ConnectionException
     */
    public function handle(): int
    {
        Estate::query()->chunk(100, function ($estates) {
            $fieldsToCheck = [
                'general_formatted',
                'heating_formatted',
                'windows_formatted',
                'kitchen_formatted'
            ];
            foreach ($estates as $estate) {
                $extraInfo = $this->imobManager->get("estate/{$estate->imobmanager_id}");

                $extraInfoArray = [];

                foreach ($fieldsToCheck as $field) {
                    if (!empty($extraInfo[$field])) {
                        // Split the value into individual items if it contains commas
                        $values = array_map('trim', explode(',', $extraInfo[$field]));

                        // Merge the new values into the existing array
                        $extraInfoArray = array_merge($extraInfoArray, $values);
                    }
                }

                if (!empty($extraInfoArray)) {
                    $estate->estate_properties = array_unique($extraInfoArray);
                }

                if (!empty($extraInfo['offer_type'])) {
                    $estate->offer_type_id = $extraInfo['offer_type']['original_value'];

                    foreach ($extraInfo['offer_type']['values'] as $value) {
                        $offerType = OfferType::query()->where('imobmanager_id', $extraInfo['offer_type']['original_value'])->first();

                        if (!$offerType) {
                            $offerType = new OfferType();
                            $offerType->imobmanager_id = $extraInfo['offer_type']['original_value'];
                            $offerType->name = $value;
                            $offerType->save();
                        }
                    }
                }

                if (!empty($extraInfo['estate_type'])) {
                    $estate->estate_type_id = $extraInfo['estate_type']['original_value'];

                    foreach ($extraInfo['estate_type']['values'] as $value) {
                        $estateType = EstateType::query()->where('imobmanager_id', $extraInfo['estate_type']['original_value'])->first();

                        if (!$estateType) {
                            $estateType = new EstateType();
                            $estateType->imobmanager_id = $extraInfo['estate_type']['original_value'];
                            $estateType->name = $value;
                            $estateType->save();
                        }
                    }
                }

                $estate->last_sync = now();

                $estate->save();
            }
        });

        return 0;
    }
}
