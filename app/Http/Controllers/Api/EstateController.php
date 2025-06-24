<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Agency;
use App\Models\County;
use App\Models\Estate;
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
     *     summary="Create a new estate listing",
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
        $request->validate([
            'idintern' => 'required|integer',
            'titlu' => 'required|string',
            'pretvanzare' => 'required|integer',
            'pretinchiriere' => 'required|integer',
            'anulconstructiei' => 'required|integer',
            'poze' => 'required|string',
        ]);

        $estateData = [
            'idintern' => $request->input('idintern'),
            'oldid' => $request->input('oldid'),
            'avemcheile' => $request->input('avemcheile'),
            'idansamblu' => $request->input('idansamblu'),
            'idagent' => $request->input('idagent'),
            'numeagent' => $request->input('numeagent'),
            'prenumeagent' => $request->input('prenumeagent'),
            'emailagent' => $request->input('emailagent'),
            'telefonagent' => $request->input('telefonagent'),
            'pozaagent' => $request->input('pozaagent'),
            'numecontact' => $request->input('numecontact'),
            'prenumecontact' => $request->input('prenumecontact'),
            'emailcontact' => $request->input('emailcontact'),
            'telefoncontact' => $request->input('telefoncontact'),
            'judetul' => $request->input('judetul'),
            'localitatea' => $request->input('localitatea'),
            'cartierul' => $request->input('cartierul'),
            'tipoferta' => $request->input('tipoferta'),
            'tipoperatiune' => $request->input('tipoperatiune'),
            'titlu' => $request->input('titlu'),
            'titluen' => $request->input('titluen'),
            'descriere' => $request->input('descriere'),
            'descriereen' => $request->input('descriereen'),
            'video' => $request->input('video'),
            'vrtour' => $request->input('vrtour'),
            'latitudine' => $request->input('latitudine'),
            'longitudine' => $request->input('longitudine'),
            'promovata' => $request->input('promovata'),
            'exclusiva' => $request->input('exclusiva'),
            'comision0' => $request->input('comision0'),
            'adresa' => $request->input('adresa'),
            'pretvanzare' => $request->input('pretvanzare'),
            'pretinchiriere' => $request->input('pretinchiriere'),
            'negociabil' => $request->input('negociabil'),
            'pretmp' => $request->input('pretmp'),
            'plustva' => $request->input('plustva'),
            'moneda' => $request->input('moneda'),
            'clasaenergetica' => $request->input('clasaenergetica'),
            'consumenergieprimara' => $request->input('consumenergieprimara'),
            'indiceconsumco2' => $request->input('indiceconsumco2'),
            'consumenergieregenerabila' => $request->input('consumenergieregenerabila'),
            'etaj' => $request->input('etaj'),
            'etaje' => $request->input('etaje'),
            'subsol' => $request->input('subsol'),
            'demisol' => $request->input('demisol'),
            'parter' => $request->input('parter'),
            'mansarda' => $request->input('mansarda'),
            'pod' => $request->input('pod'),
            'suprafatautila' => $request->input('suprafatautila'),
            'suprafataconstruita' => $request->input('suprafataconstruita'),
            'suprafatateren' => $request->input('suprafatateren'),
            'deschidere' => $request->input('deschidere'),
            'numarfronturi' => $request->input('numarfronturi'),
            'anulconstructiei' => $request->input('anulconstructiei'),
            'confort' => $request->input('confort'),
            'compartimentare' => $request->input('compartimentare'),
            'numarcamere' => $request->input('numarcamere'),
            'numardormitoare' => $request->input('numardormitoare'),
            'numarbucatarii' => $request->input('numarbucatarii'),
            'numarbai' => $request->input('numarbai'),
            'disponibilitate' => $request->input('disponibilitate'),
            'numarterase' => $request->input('numarterase'),
            'suprafataterase' => $request->input('suprafataterase'),
            'inaltimespatiu' => $request->input('inaltimespatiu'),
            'clasabirouri' => $request->input('clasabirouri'),
            'regiminaltime' => $request->input('regiminaltime'),
            'tipteren' => $request->input('tipteren'),
            'destinatieteren' => $request->input('destinatieteren'),
            'terenparcelabil' => $request->input('terenparcelabil'),
            'amprenta' => $request->input('amprenta'),
            'pot' => $request->input('pot'),
            'cut' => $request->input('cut'),
            'metrou' => $request->input('metrou'),
            'locuriparcare' => $request->input('locuriparcare'),
            'tipspatiu' => $request->input('tipspatiu'),
            'tipimobil' => $request->input('tipimobil'),
            'detaliiprivate' => $request->input('detaliiprivate'),
            'stadiuconstructie' => $request->input('stadiuconstructie'),
            'optiuni' => $request->input('optiuni'),
            'poze' => $request->input('poze'),
        ];


        // Find or create the agent
        $agentName = trim("{$estateData['prenumeagent']} {$estateData['numeagent']}");

        $agent = User::query()->updateOrCreate(
            ['email' => $estateData['emailagent']], // Identify agents by their unique external ID
            [
                'name' => $agentName,
                'email' => $estateData['emailagent'] ?? null,
                'slug' => User::generateUniqueSlug($agentName, $estateData['emailagent']),
                'phone' => $estateData['telefonagent'] ?? null,
                'position' => 'Agent',
                'agency_id' => Agency::query()->first()->id ?? null,
                'picture' => $estateData['pozaagent'] ?? null,
                'password' => env('FILAMENT_BASE_PASSWORD'),
            ]
        );

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

        $slug = Estate::query()->where('crm_id', '=', $estateData['idintern'])->first()?->slug;

        return response()->json([
            'success' => 'Estate created successfully.',
            'estate_url' => route('estate.show', ['slug' => $slug]),
        ]);
    }
}
