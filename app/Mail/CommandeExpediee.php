<?php

namespace App\Mail;

use App\Models\Commande;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Barryvdh\DomPDF\PDF; // Ajoutez cette ligne pour le typage

class CommandeExpediee extends Mailable
{
    use Queueable, SerializesModels;

    public $commande;
    protected $pdf;

    /**
     * @param Commande $commande
     * @param PDF $pdf L'instance du PDF générée
     */
    public function __construct(Commande $commande, $pdf)
    {
        $this->commande = $commande;
        $this->pdf = $pdf; // Stockez l'objet PDF complet
    }

    public function build()
    {
        return $this->subject('Votre commande a été expédiée Ci-joint votre facture')
            ->view('pdf.facture', ['commande' => $this->commande]);

    }
}
