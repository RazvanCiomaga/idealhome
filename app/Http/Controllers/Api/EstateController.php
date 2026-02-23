<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Agency;
use App\Models\County;
use App\Models\Estate;
use App\Models\EstateType;
use App\Models\OfferType;
use App\Models\RoomEntrance;
use App\Models\User;
use App\Models\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Stevebauman\Purify\Facades\Purify;

/**
 * @OA\Info(
 *     title="IdealHome API",
 *     version="1.0",
 *     description="API for managing real estate listings"
 * )
 *
 * @OA\Tag(
 *     name="Estates",
 *     description="Endpoints for estate management"
 * )
 */
class EstateController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/estates/create",
     *     summary="Create or update a estate listing",
     *     security={{"sanctum":{}}},
     *     tags={"Estates"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"idintern", "title", "title_en", "pretvanzare", "pretinchiriere", "anulconstructiei", "poze"},
     *             @OA\Property(property="idintern", type="integer", example=704),
     *             @OA\Property(property="oldid", type="integer", example=1234),
     *             @OA\Property(property="avemcheile", type="boolean", example=true),
     *             @OA\Property(property="idansamblu", type="integer", example=56),
     *             @OA\Property(property="idagent", type="integer", example=7),
     *             @OA\Property(property="numeagent", type="string", example="Nume"),
     *             @OA\Property(property="prenumeagent", type="string", example="Prenume"),
     *             @OA\Property(property="emailagent", type="string", example="agent@gmail.com"),
     *             @OA\Property(property="telefonagent", type="string", example="07******94"),
     *             @OA\Property(property="pozaagent", type="string", example="http://crm.ideal-home.net/images/admins/agent_id.jpg"),
     *             @OA\Property(property="numecontact", type="string", example="John"),
     *             @OA\Property(property="prenumecontact", type="string", example="Doe"),
     *             @OA\Property(property="emailcontact", type="string", example="johndoe@example.com"),
     *             @OA\Property(property="telefoncontact", type="string", example="0712345678"),
     *             @OA\Property(property="judetul", type="string", example="Iasi"),
     *             @OA\Property(property="localitatea", type="string", example="Iasi"),
     *             @OA\Property(property="cartierul", type="string", example="Pacurari"),
     *             @OA\Property(property="tipoferta", type="string", example="vanzare"),
     *             @OA\Property(property="tipoperatiune", type="string", example="vanzare"),
     *             @OA\Property(property="titlu", type="string", example="Apartament cu 2 camere"),
     *             @OA\Property(property="titluen", type="string", example="2-room apartment"),
     *             @OA\Property(property="descriere", type="string", example="Apartament modern in zona centrala."),
     *             @OA\Property(property="descriereen", type="string", example="Modern apartment in the central area."),
     *             @OA\Property(property="video", type="string", example="http://example.com/video.mp4"),
     *             @OA\Property(property="vrtour", type="string", example="http://example.com/vrtour"),
     *             @OA\Property(property="latitudine", type="string", example="47.1585"),
     *             @OA\Property(property="longitudine", type="string", example="27.6014"),
     *             @OA\Property(property="pretvanzare", type="integer", example=75000),
     *             @OA\Property(property="pretinchiriere", type="integer", example=1000),
     *             @OA\Property(property="moneda", type="string", example="EUR"),
     *             @OA\Property(property="clasaenergetica", type="string", example="B"),
     *             @OA\Property(property="numarcamere", type="integer", example=2),
     *             @OA\Property(property="numarbai", type="integer", example=1),
     *             @OA\Property(property="etaj", type="string", example="4"),
     *             @OA\Property(property="etaje", type="integer", example=10),
     *             @OA\Property(property="suprafatautila", type="integer", example=50),
     *             @OA\Property(property="suprafataconstruita", type="integer", example=60),
     *             @OA\Property(property="anulconstructiei", type="integer", example=2000),
     *             @OA\Property(property="locuriparcare", type="integer", example=1),
     *             @OA\Property(property="tipspatiu", type="string", example="apartament"),
     *             @OA\Property(property="tipimobil", type="string", example="bloc"),
     *             @OA\Property(property="detaliiprivate", type="string", example="Proprietate privata cu facilitati moderne."),
     *             @OA\Property(property="stadiuconstructie", type="string", example="Finalizat"),
     *             @OA\Property(property="optiuni", type="string", example="Balcon, Parcare, Lift"),
     *             @OA\Property(property="poze", type="string", example="http://crm.ideal-home.net/images/propertiessite/img_704_4963.jpeg, http://crm.ideal-home.net/images/propertiessite/img_704_4963.jpeg")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Estate created successfully"),
     *     @OA\Response(response=403, description="Unauthorized"),
     * )
     */
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        // 1. Let validation return only the data needed
        $validated = $request->validate([
            'idintern' => 'required|integer',
            'titlu' => 'required|string',
            'pretvanzare' => 'required|integer',
            'pretinchiriere' => 'required|integer',
            'anulconstructiei' => 'required|integer',
            'poze' => 'required|string',
        ]);

        // 2. Use $request->all() or $request->only() instead of manual mapping
        $allData = $request->all();

        // 3. Handle Agent logic concisely
        $agentName = trim(($allData['prenumeagent'] ?? '') . ' ' . ($allData['numeagent'] ?? ''));

        $agent = User::updateOrCreate(
            ['email' => $allData['emailagent']],
            [
                'name'     => $agentName,
                'phone'    => $allData['telefonagent'] ?? null,
                'position' => 'Agent',
                'picture'  => $allData['pozaagent'] ?? null,
                'password' => bcrypt(config('app.base_password')), // Use config() instead of env()
            ]
        );

        // 4. Handle Estate Type & Offer Type efficiently
        $estateType = EstateType::firstOrCreate(['name' => $allData['tipoferta']]);

        $offerType = OfferType::whereRaw('LOWER(name) = ?', [strtolower($allData['tipoperatiune'] ?? '')])->first();

        // 5. Parse images once
        $images = explode(',', $allData['poze'] ?? '');
        $mainImage = $images[0] ?? null;

        // 6. Update or Create the Estate
        $estate = Estate::updateOrCreate(
            ['crm_id' => $allData['idintern']],
            [
                'title'             => $allData['titlu'] ?? null,
                'title_en'          => $allData['titluen'] ?? null,
                'description'       => isset($allData['descriere']) ? Purify::clean($allData['descriere']) : null,
                'description_en'    => isset($allData['descriereen']) ? Purify::clean($allData['descriereen']) : null,
                'city'              => $allData['localitatea'] ?? null,
                'zone'              => $allData['cartierul'] ?? null,
                'county'            => $allData['judetul'] ?? null,
                'rooms'             => $allData['numarcamere'] ?? null,
                'bathrooms'         => $allData['numarbai'] ?? null,
                'floor'             => $allData['etaj'] ?? null,
                'max_floor'         => $allData['etaje'] ?? null,
                'area'              => $allData['suprafataconstruita'] ?? null,
                'usable_area'       => $allData['suprafatautila'] ?? null,
                'land_area'         => $allData['suprafatateren'] ?? null,
                'offer_type'        => $offerType?->id,
                'sale_price'        => (int) ($allData['pretvanzare'] ?? 0),
                'rent_price'        => (int) ($allData['pretinchiriere'] ?? 0),
                'construction_year' => $allData['anulconstructiei'] ?? null,
                'energy_class'      => $allData['clasaenergetica'] ?? null,
                'exclusive'         => (bool) ($allData['exclusiva'] ?? false),
                'comission'         => $allData['comision0'] ?? null,
                'thumb'             => $mainImage,
                'featured_image'    => $mainImage,
                'images'            => $images,
                'latitude'          => $allData['latitudine'] ?? null,
                'longitude'         => $allData['longitudine'] ?? null,
                'agent_id'          => $agent->id,
                'estate_properties' => array_filter(explode(';', $allData['optiuni'] ?? '')),
                'estate_type_id'    => $estateType->id,
            ]
        );

        // 7. Sync ancillary tables (Check only if data exists)
        if ($val = ($allData['cartierul'] ?? null)) Zone::firstOrCreate(['name' => $val]);
        if ($val = ($allData['judetul'] ?? null)) County::firstOrCreate(['name' => $val]);
        if ($val = ($allData['compartimentare'] ?? null)) RoomEntrance::firstOrCreate(['name' => $val]);

        // 8. Return immediately using the $estate instance
        return response()->json([
            'success'    => 'Estate processed successfully.',
            'estate_url' => route('estate.show', $estate->slug), // Laravel finds the slug automatically
        ]);
    }


    /**
     * @OA\Delete(
     *     path="/api/estates/delete/{idintern}",
     *     summary="Delete an estate listing by CRM ID",
     *     security={{"sanctum":{}}},
     *     tags={"Estates"},
     *     @OA\Parameter(
     *         name="idintern",
     *         in="path",
     *         required=true,
     *         description="The unique external CRM ID of the estate to delete",
     *         @OA\Schema(type="integer", example=704)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Estate deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="string", example="Estate deleted successfully.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Estate not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Estate not found.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Unauthorized"
     *     )
     * )
     */
    public function destroy($idintern): \Illuminate\Http\JsonResponse
    {
        // Find estate by external CRM ID
        $estate = Estate::query()->where('crm_id', $idintern)->first();

        if (!$estate) {
            return response()->json(['error' => 'Estate not found.'], 404);
        }

        $estate->delete();

        return response()->json(['success' => 'Estate deleted successfully.']);
    }
}
