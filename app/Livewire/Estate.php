<?php

namespace App\Livewire;

use App\Mail\PossibleClient as PossibleClientMail;
use App\Models\PossibleClient;
use App\Models\User;
use App\Models\Estate as EstateModel;
use Illuminate\Support\Facades\Mail;
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

    public function mount($slug): void
    {
        $this->slug = $slug;
        $this->estate = EstateModel::query()->where('slug', $this->slug)->first();
        $this->agent = $this->estate?->agent;
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
            // Send the email
            Mail::to($this->agent->email)->send(new PossibleClientMail([
                'name' => $this->clientName,
                'email' => $this->clientEmail,
                'phone' => $this->clientPhone,
                'message' => $this->clientMessage,
                'subject' => $this->estate->title,
            ]));

            $possibleClient = PossibleClient::query()->where('email', $this->clientEmail)->first();

            if (!$possibleClient) {
                $possibleClient = new PossibleClient();
                $possibleClient->name = $this->clientName;
                $possibleClient->email = $this->clientEmail;
                $possibleClient->phone = $this->clientPhone;
                $possibleClient->save();

                $possibleClient->estates()->syncWithoutDetaching([$this->estate->id]);
            }

            $this->clientName = '';
            $this->clientEmail = '';
            $this->clientPhone = '';
            $this->clientMessage = '';

            // Optionally set a confirmation message
            session()->flash('message', 'Email sent successfully!');

        } catch (\Exception $e) {
            // Optionally handle the error (e.g., log it or set an error message)
            session()->flash('error', 'Failed to send email: ' . $e->getMessage());
        }
    }
}
