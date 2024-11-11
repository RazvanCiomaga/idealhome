<?php

namespace App\Livewire;

use App\Mail\PossibleClient as PossibleClientMail;
use App\Models\Agency;
use App\Models\PossibleClient;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class Contact extends Component
{
    public string $clientName = '';
    public string $clientEmail = '';
    public string $clientPhone = '';
    public string $clientMessage = '';

    public Agency|null $agency;

    public function mount(): void
    {
        $this->agency = Agency::query()->first();
    }

    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
        return view('livewire.contact');
    }

    public function sendMessage(): void
    {
        if (!$this->agency?->email) {
            return;
        }

        try {
            // Send the email
            Mail::to($this->agency->email)->send(new PossibleClientMail([
                'name' => $this->clientName,
                'email' => $this->clientEmail,
                'phone' => $this->clientPhone,
                'message' => $this->clientMessage,
                'subject' => 'Posibil Client',
            ]));

            $possibleClient = PossibleClient::query()->where('email', $this->clientEmail)->first() ?? new PossibleClient();

            $possibleClient->name = $this->clientName;
            $possibleClient->email = $this->clientEmail;
            $possibleClient->phone = $this->clientPhone;
            $possibleClient->message = $this->clientMessage;
            $possibleClient->save();

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
