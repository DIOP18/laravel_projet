<?php

namespace App\Mail;

use App\Models\Commande;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CommandePayer extends Mailable
{
    use Queueable, SerializesModels;
    public Commande $commande;

    /**
     * Create a new message instance.
     */
    public function __construct(Commande $commande)
    {
        $this->commande = $commande->load('livre');
    }
    public function build()
    {
        return $this->subject('Nouvelle commande payée - À livrer')
            ->view('emails.commandes-payee');
    }

}
