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

        // 4. Nombre de commandes par mois (pour l'année en cours)
        $commandesParMois = DB::table('commandes')
            ->select(
                DB::raw('MONTH(created_at) as mois'),
                DB::raw('COUNT(*) as nombre')
            )
            ->whereYear('created_at', date('Y'))
            ->groupBy('mois')
            ->orderBy('mois')
            ->get();

        $moisLabels = [];
        $commandesData = array_fill(1, 12, 0);

        // Remplir avec les données réelles
        foreach ($commandesParMois as $data) {
            $mois = $data->mois;
            $commandesData[$mois] = $data->nombre;
            $moisLabels[$mois] = Carbon::create()->month($mois)->locale('fr_FR')->monthName;
        }

        // 5. Nombre de livres vendus par catégorie par mois
        $livresParCategorie = DB::table('commandes')
            ->join('livre_models', 'commandes.livre_id', '=', 'livre_models.id')
            ->select(
                'livre_models.categorie',
                DB::raw('MONTH(commandes.created_at) as mois'),
                DB::raw('SUM(commandes.quantite) as quantite')
            )
            ->where('commandes.statut', 'payee')
            ->whereYear('commandes.created_at', date('Y'))
            ->groupBy('livre_models.categorie', 'mois')
            ->orderBy('mois')
            ->get();

        // Récupérer toutes les catégories distinctes
        $categories = DB::table('livre_models')
            ->select('categorie')
            ->distinct()
            ->pluck('categorie')
            ->toArray();

        // Initialiser les données
        $ventesParCategorie = [];
        foreach ($categories as $categorie) {
            $ventesParCategorie[$categorie] = array_fill(1, 12, 0);
        }

        // Remplir avec les données réelles
        foreach ($livresParCategorie as $data) {
            $categorie = $data->categorie;
            $mois = $data->mois;
            $ventesParCategorie[$categorie][$mois] = $data->quantite;
        }

        return view('Statistiques.statistique', compact(
            'commandesEnCours',
            'commandesValidees',
            'recettesJournalieres',
            'moisLabels',
            'commandesData',
            'categories',
            'ventesParCategorie'
        ));
    }
}
