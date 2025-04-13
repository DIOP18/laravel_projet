@extends('nav')
@section('navbar')
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>Stats</title>
</head>
<body>
<div class="container py-4">
    <h1 class="mb-4">Tableau de Bord Statistique</h1>
    <div class="row mb-4">
        <div class="col-md-12 text-end">
            <a href="{{ route('stats-download') }}" class="btn btn-success">
                <i class="fas fa-file-pdf me-2"></i>Télécharger le PDF
            </a>
        </div>
    </div>

    <!-- KPI Cards -->
    <div class="row mb-4">
        <!-- Commandes en cours -->
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm border-primary">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Commandes en cours</h6>
                            <h3 class="mb-0">{{ $commandesEnCours }}</h3>
                        </div>
                        <div class="bg-primary bg-opacity-10 p-3 rounded">
                            <i class="fas fa-clock fa-2x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Commandes validées -->
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm border-success">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Commandes validées</h6>
                            <h3 class="mb-0">{{ $commandesValidees }}</h3>
                        </div>
                        <div class="bg-success bg-opacity-10 p-3 rounded">
                            <i class="fas fa-check-circle fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recettes -->
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm border-warning">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Recettes journalières</h6>
                            <h3 class="mb-0">{{ number_format($recettesJournalieres, 0, ',', ' ') }} FCFA</h3>
                            <small class="text-muted">{{ number_format($recettesMensuelles, 0, ',', ' ') }} FCFA ce mois</small>
                        </div>
                        <div class="bg-warning bg-opacity-10 p-3 rounded">
                            <i class="fas fa-money-bill-wave fa-2x text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row">
        <div class="col-md-8 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title">Évolution des commandes</h5>
                    <div style="height: 250px;">
                        <canvas id="commandesChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title">Livres par catégorie</h5>
                    <div style="height: 250px;">
                        <canvas id="categorieChart"></canvas>
                    </div>
                    @if($livresParCategorie->first()->categorie == 'Aucune donnée')
                        <div class="alert alert-warning mt-3 mb-0">
                            Aucune donnée disponible
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    </div>
</div>


    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Commandes par mois - Line Chart
        const commandesCtx = document.getElementById('commandesChart').getContext('2d');
        new Chart(commandesCtx, {
            type: 'line',
            data: {
                labels: @json($moisLabels),
                datasets: [{
                    label: 'Nombre de commandes',
                    data: @json($commandesData),
                    backgroundColor: 'rgba(13, 110, 253, 0.1)',
                    borderColor: 'rgba(13, 110, 253, 1)',
                    borderWidth: 2,
                    tension: 0.3,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });

        // Répartition par statut - Doughnut Chart
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('categorieChart');
            if (ctx) {
                const data = {
                    labels: @json($livresParCategorie->pluck('categorie')),
                    datasets: [{
                        data: @json($livresParCategorie->pluck('total_livres')),
                        backgroundColor: [
                            '#FF6384', '#36A2EB', '#FFCE56',
                            '#4BC0C0', '#9966FF', '#FF9F40'
                        ],
                        borderWidth: 1
                    }]
                };

                new Chart(ctx, {
                    type: 'pie',
                    data: data,
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'right',
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return `${context.label}: ${context.raw} livre(s)`;
                                    }
                                }
                            }
                        }
                    }
                });
            }
        });
    </script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


</body>
</html>
@endsection
