<?php

namespace App\Livewire;

use App\Mail\PossibleClient as PossibleClientMail;
use App\Models\EstateType;
use App\Models\OfferType;
use App\Models\PossibleClient;
use App\Models\RoomEntrance;
use App\Models\User;
use App\Models\Estate as EstateModel;
use App\Models\Zone;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class Estate extends Component
{
    public string $slug;
    public EstateModel|null $estate;
    public User|null $agent;

    public string $clientName = '';
    public string $clientEmail = '';
    public string $clientPhone = '';
    public string $clientMessage = '';

    public string $defaultSelect = 'none';

    public string $roomEntrance = 'none';

    public string $zone = 'none';

    public $year = '';

    public $floor = 'none';


    public $offerType = 1;

    public  array $filters = [];

    public $estateType = 'none';

    public function mount($slug): void
    {
        $this->slug = $slug;
        $this->estate = EstateModel::with(['agent'])
            ->where('slug', $slug)
            ->firstOrFail();

        $this->agent = $this->estate?->agent;
        $this->offerType = $this->estate?->offer_type_id ?? 1;
        $this->getFilters();

        // Get the visited estates array from session or create an empty one
        $visitedEstates = Session::get('visited_estates', []);

        if (!in_array($slug, $visitedEstates)) {
            // Increment visits count
            $this->estate->visits += 1;
            $this->estate->saveQuietly();

            // Add slug to session array
            $visitedEstates[] = $slug;
            Session::put('visited_estates', $visitedEstates);
        }
    }

    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
        return view('livewire.estate');
    }

    public function sendMessage(): void
    {
        if (empty($this->clientEmail)) {
            return;
        }

        try {
            $possibleClient = PossibleClient::query()->where('email', $this->clientEmail)->first() ?? new PossibleClient();

            $possibleClient->name = $this->clientName;
            $possibleClient->email = $this->clientEmail;
            $possibleClient->phone = $this->clientPhone;
            $possibleClient->message = $this->clientMessage;
            $possibleClient->save();

            $possibleClient->estates()->syncWithoutDetaching([$this->estate->id]);

            // Send the email
            Mail::to($this->agent->email)->send(new PossibleClientMail([
                'name' => $this->clientName,
                'email' => $this->clientEmail,
                'phone' => $this->clientPhone,
                'message' => $this->clientMessage,
                'subject' => $this->estate->title,
            ]));

            // Optionally set a confirmation message
            session()->flash('message', 'Email sent successfully!');

            $this->clientName = '';
            $this->clientEmail = '';
            $this->clientPhone = '';
            $this->clientMessage = '';
        } catch (\Exception $e) {
            // Optionally handle the error (e.g., log it or set an error message)
            session()->flash('error', 'Failed to send email: ' . $e->getMessage());
        }
    }

    public function getFilters(): void
    {
        $this->filters = [
            'roomEntrances' => RoomEntrance::query()->orderBy('name')->get()->pluck('name', 'name')->toArray(),
            'zones' => Zone::query()->orderBy('name')->get()->pluck('name', 'name')->toArray(),
            'construction_year' => [
                'before' => label('Inainte de 1977'),
                'after' => label('Dupa 1977'),
            ],
            'floors' => [
                'Parter' => label('Parter'),
                1 => 1,
                2 => 2,
                3 => 3,
                4 => 4,
                5 => 5,
                6 => 6,
                7 => 7,
                8 => 8,
                9 => 9,
                10 => 10,
            ],
            'estateTypes' => EstateType::query()->orderBy('name')->get()->pluck('name', 'imobmanager_id')->toArray(),
            'offerTypes' => OfferType::query()->orderBy('name')->get()->pluck('name', 'imobmanager_id')->toArray(),
        ];
    }

    public function applyFilters()
    {
        if ($this->offerType === 1) {
            return redirect()->route('sales-listings', [
                'roomEntrance' => $this->roomEntrance,
                'zone' => $this->zone,
                'year' => $this->year,
                'floor' => $this->floor,
                'estateType' => $this->estateType,
            ]);
        } else {
            return redirect()->route('rent-listings', [
                'roomEntrance' => $this->roomEntrance,
                'zone' => $this->zone,
                'year' => $this->year,
                'floor' => $this->floor,
                'estateType' => $this->estateType,
            ]);
        }
    }
}
