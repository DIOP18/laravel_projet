<?php

namespace App\Http\Controllers;

use App\Mail\CommandeExpediee;
use App\Mail\CommandePayer;
use App\Mail\ConfirmationCommande;
use App\Mail\NouvelleCommandeGestionnaire;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Commande;
use App\Models\LivreModel;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;


class CommandeController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'livre_id' => 'required|exists:livre_models,id',
            'quantite' => 'required|integer|min:1',
            'email' => 'required|email'
        ]);

        // Utilisation de transaction pour plus de sécurité
        return DB::transaction(function () use ($request) {
            $livre = LivreModel::where('id', $request->livre_id)
                ->where('Stockdisponible', '>=', $request->quantite)
                ->lockForUpdate()
                ->firstOrFail();

            $livre->decrement('Stockdisponible', $request->quantite);

            if ($livre->Stockdisponible <= 0) {
                $livre->archived = true;
                $livre->save();
            }

            $commande = Commande::create([
                'livre_id' => $request->livre_id,
                'quantite' => $request->quantite,
                'email' => $request->email,
                'total' => $livre->prix * $request->quantite,
                'statut' => 'en_attente'
            ]);

            Mail::to($request->email)->send(new ConfirmationCommande($commande));

            $admins = User::where('role', 'gestionnaire')->get();
            foreach ($admins as $admin) {
                Mail::to($admin->email)->send(new NouvelleCommandeGestionnaire($commande));
            }

            return redirect()->route('showDetails', $livre->id)
                ->with('success', 'Commande passée avec succès! Un email de confirmation vous a été envoyé.');
        });


    }

    public function index()
    {
        $commandes = Commande::with('livre')->orderBy('created_at', 'desc')->paginate(10);
        return view('commandes.index', compact('commandes'));
    }

    public function show($id)
    {
        $commande = Commande::with('livre')->findOrFail($id);
        return view('commandes.DetailsCommande', compact('commande'));
    }

    public function cancel($id)
    {
        $commande = Commande::findOrFail($id);
        $commande->statut = 'annulée';
        $commande->save();

        // Si vous voulez remettre le livre en stock
        if ($commande->livre) {
            $commande->livre->increment('Stockdisponible', $commande->quantite);
            if ($commande->livre->archived && $commande->livre->Stockdisponible > 0) {
                $commande->livre->archived = false;
                $commande->livre->save();
            }
        }

        return redirect()->route('index')
            ->with('success', 'La commande a été annulée avec succès.');
    }
    public function mesCommandes()
    {

        $email = auth()->user()->email;

        $commandes = Commande::with('livre')
            ->where('email', $email)
            ->latest()
            ->paginate(10);

        return view('commandes.mescommandes', compact('commandes'));
    }

    public function PaiementCommandes(Request $request)
    {
        $request->validate([
            'commande_id' => 'required|exists:commandes,id',
            'payment_method' => 'required|in:espece,carte',
        ]);

        $commande = Commande::findOrFail($request->commande_id);

        // Vérification par email au lieu de user_id
        if ($commande->email !== auth()->user()->email) {
            return back()->with('error', 'Cette commande ne vous appartient pas.');
        }

        if ($commande->statut == 'payee') {
            return back()->with('error', 'Commande déjà payée.');
        }

        $commande->update([
            'statut' => 'payee',
            'payment_method' => $request->payment_method,
            'payment_date' => now()
        ]);

        // Envoi des emails...
        $admins = User::where('role', 'gestionnaire')->get();
        foreach ($admins as $admin) {
            Mail::to($admin->email)->send(new CommandePayer($commande));
        }

        return redirect()->route('mescommandes')
            ->with('paiement', 'Paiement effectué avec succès!');
    }
    public function expedier($id)
    {
        try {
            $commande = Commande::with('livre')->findOrFail($id);

            // Vérification que la relation livre existe
            if (!$commande->livre) {
                return back()->with('error', 'Erreur: Cette commande n\'a pas de livre associé');
            }

            $pdf = PDF::loadView('pdf.facture', ['commande' => $commande]);

            // Envoi de l'email
            Mail::to($commande->email)->send(new CommandeExpediee($commande, $pdf));

            // Journalisation
            Log::info("Commande #{$commande->id} expédiée à {$commande->email}");

            // Mise à jour du statut
            $commande->update(['statut' => 'expediee']);

            return redirect()
                ->route('DetailsCommande', $commande->id)
                ->with('livraison', 'Commande expédiée avec succès');
        } catch (\Exception $e) {
            Log::error("Erreur expédition #{$id}: " . $e->getMessage());
            return back()->with('error', 'Erreur lors de l\'expédition: ' . $e->getMessage());
        }
    }
}
