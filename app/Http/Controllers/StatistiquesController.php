<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StatistiquesController extends Controller
{
    public function index()
    {
        // Date du jour
        $today = Carbon::today();
        $firstDayOfMonth = Carbon::now()->firstOfMonth();

        // 1. Commandes en cours de la journée
        $commandesEnCours = Commande::where('statut', 'en_attente')
            ->whereDate('created_at', $today)
            ->count();

        // 2. Commandes validées de la journée
        $commandesValidees = Commande::where('statut', 'payee')
            ->whereDate('created_at', $today)
            ->count();

        // 3. Recettes journalières (total des paiements reçus)
        $recettesJournalieres = Commande::where('statut', 'payee')
            ->whereDate('created_at', $today)
            ->sum('total');

        // 4. Recettes mensuelles
        $recettesMensuelles = Commande::where('statut', 'payee')
            ->whereDate('created_at', '>=', $firstDayOfMonth)
            ->sum('total');

        // 5. Nombre de commandes par mois (pour les 6 derniers mois)
        $sixMonthsAgo = Carbon::now()->subMonths(6);

        $commandesParMois = Commande::select(
            DB::raw('MONTH(created_at) as mois'),
            DB::raw('YEAR(created_at) as annee'),
            DB::raw('COUNT(*) as nombre')
        )
            ->whereDate('created_at', '>=', $sixMonthsAgo)
            ->groupBy('annee', 'mois')
            ->orderBy('annee')
            ->orderBy('mois')
            ->get();

        // Préparation des données pour le graphique
        $moisLabels = [];
        $commandesData = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $moisKey = $date->format('Y-m');
            $moisLabels[] = $date->locale('fr_FR')->monthName . ' ' . $date->year;

            $trouve = $commandesParMois->first(function ($item) use ($date) {
                return $item->mois == $date->month && $item->annee == $date->year;
            });

            $commandesData[] = $trouve ? $trouve->nombre : 0;
        }

        // 6. Commandes par statut (pour le pie chart)
        $livresParCategorie = DB::table('commandes')
            ->join('livre_models', 'commandes.livre_id', '=', 'livre_models.id')
            ->select(
                'livre_models.categorie',
                DB::raw('COALESCE(SUM(commandes.quantite), 0) as total_livres')
            )
            ->where('commandes.statut', 'expediee')
            ->groupBy('livre_models.categorie')
            ->orderBy('total_livres', 'DESC')
            ->get();

        // Ajoutez des données par défaut si vide
        if ($livresParCategorie->isEmpty()) {
            $livresParCategorie = collect([
                (object)['categorie' => 'Aucune donnée', 'total_livres' => 1]
            ]);
        }


        return view('Statistiques.statistique', compact(
            'commandesEnCours',
            'commandesValidees',
            'recettesJournalieres',
            'recettesMensuelles',
            'moisLabels',
            'commandesData',
            'livresParCategorie'
        ));
    }
}
