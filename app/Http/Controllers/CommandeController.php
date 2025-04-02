<?php

namespace App\Http\Controllers;

use App\Mail\ConfirmationCommande;
use App\Models\Commande;
use App\Models\LivreModel;
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

            return redirect()->route('showDetails', $livre->id)
                ->with('success', 'Commande passée avec succès! Un email de confirmation vous a été envoyé.');
        });
    }
    //
}
