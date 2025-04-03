<?php

namespace App\Http\Controllers;

use App\Mail\ConfirmationCommande;
use App\Mail\NouvelleCommandeGestionnaire;
use App\Models\Commande;
use App\Models\LivreModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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


    //
}
