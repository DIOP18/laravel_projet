<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Statistiques</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        .header { text-align: center; margin-bottom: 20px; }
        .kpi { margin-bottom: 15px; padding: 10px; border: 1px solid #ddd; }
        .kpi-title { font-weight: bold; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
<div class="header">
    <h1>Tableau de Bord Statistique</h1>
    <p>Généré le: {{ now()->format('d/m/Y H:i') }}</p>
</div>

<div class="kpis">
    <div class="kpi">
        <span class="kpi-title">Commandes en cours:</span> {{ $commandesEnCours }}
    </div>
    <div class="kpi">
        <span class="kpi-title">Commandes validées:</span> {{ $commandesValidees }}
    </div>
    <div class="kpi">
        <span class="kpi-title">Recettes journalières:</span> {{ number_format($recettesJournalieres, 0, ',', ' ') }} FCFA
    </div>
    <div class="kpi">
        <span class="kpi-title">Recettes mensuelles:</span> {{ number_format($recettesMensuelles, 0, ',', ' ') }} FCFA
    </div>
</div>

<h2>Commandes par mois</h2>
<table>
    <thead>
    <tr>
        <th>Mois</th>
        <th>Nombre de commandes</th>
    </tr>
    </thead>
    <tbody>
    @for($i = 0; $i < count($moisLabels); $i++)
        <tr>
            <td>{{ $moisLabels[$i] }}</td>
            <td>{{ $commandesData[$i] }}</td>
        </tr>
    @endfor
    </tbody>
</table>

<h2>Livres par catégorie</h2>
<table>
    <thead>
    <tr>
        <th>Catégorie</th>
        <th>Quantité vendue</th>
    </tr>
    </thead>
    <tbody>
    @foreach($livresParCategorie as $categorie)
        <tr>
            <td>{{ $categorie->categorie }}</td>
            <td>{{ $categorie->total_livres }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
