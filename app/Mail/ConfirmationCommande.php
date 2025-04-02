<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Commande;

class ConfirmationCommande extends Mailable
{
    use Queueable, SerializesModels;

    public Commande $commande;

    public function __construct(Commande $commande)
    {
        $this->commande = $commande->load('livre');
    }

    public function build()
    {
        return $this->subject('Confirmation de votre commande')
            ->view('emails.confirmation-commande')
        ;
    }
}
