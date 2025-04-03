<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Commande;

class NouvelleCommandeGestionnaire extends Mailable
{
    use Queueable, SerializesModels;

    public Commande $commande;

    /**
     * Create a new message instance.
     *
     * @param Commande $commande
     * @return void
     */
    public function __construct(Commande $commande)
    {
        $this->commande = $commande->load(['livre']);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Nouvelle commande #' . $this->commande->reference)
            ->view('emails.gestionnaire-nouvelle-commande');
    }
}
