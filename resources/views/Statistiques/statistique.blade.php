@extends("nav")
@section("navbar")
    <!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Exécutif - Statistiques</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #34495e;
            --accent-color: #3498db;
            --success-color: #2ecc71;
            --warning-color: #f39c12;
            --danger-color: #e74c3c;
            --light-color: #ecf0f1;
        }

        body {
            background-color: #f5f7fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
        }

        .dashboard-header {
            background: #3370b1;
            color: white;
            padding: 20px 0;
            margin-bottom: 30px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .dashboard-title {
            font-weight: 300;
            letter-spacing: 0.5px;
        }

        .dashboard-subtitle {
            opacity: 0.8;
            font-weight: 300;
        }

        .stat-card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.06);
            padding: 25px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            margin-bottom: 25px;
            position: relative;
            overflow: hidden;
            border: none;
            height: 100%;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1);
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            height: 4px;
            width: 100%;
        }

        .stat-card.primary .stat-icon { color: #3498db; }
        .stat-card.success .stat-icon { color: #2ecc71; }
        .stat-card.warning .stat-icon { color: #f39c12; }

        .stat-number {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 10px;
            color: #2c3e50;
        }

        .stat-label {
            font-size: 14px;
            color: #7f8c8d;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .chart-card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.06);
            padding: 20px;
            margin-bottom: 25px;
        }

        .chart-header {
            padding-bottom: 15px;
            margin-bottom: 20px;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .chart-title {
            font-size: 18px;
            font-weight: 600;
            color: #2c3e50;
            margin: 0;
        }

        .chart-container {
            height: 300px;
            position: relative;
        }

        .time-filter {
            background: white;
            border-radius: 20px;
            padding: 5px 20px;
            display: inline-flex;
            margin-bottom: 25px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }

        .time-filter a {
            padding: 5px 15px;
            color: #95a5a6;
            text-decoration: none;
            border-radius: 15px;
            margin: 0 5px;
            font-size: 14px;
            transition: all 0.2s ease;
        }

        .time-filter a.active {
            background: #3498db;
            color: white;
        }

        .time-filter a:hover:not(.active) {
            color: #3498db;
        }

        .stat-trend {
            font-size: 14px;
            margin-top: 10px;
        }

        .trend-up { color: #2ecc71; }
        .trend-down { color: #e74c3c; }

    </style>
</head>
<body>
<div class="dashboard-header">
    <div class="container">
        <h1 class="dashboard-title">
            <i class="fas fa-chart-line me-2"></i>Tableau de Bord des Statistiques et Rapports
        </h1>
        <p class="dashboard-subtitle">
            Statistiques des Comptes MISSTECH LIBRAIRIE
        </p>
    </div>
</div>

<div class="container">
    <!-- Date et filtres -->
    <div class="row align-items-center mb-4">
        <div class="col-md-6">
            <h3 class="mb-0">{{ now()->locale('fr_FR')->format('d F Y') }}</h3>
            <p class="text-muted mb-0">Dernière mise à jour: {{ now()->locale('fr_FR')->format('H:i') }}</p>
        </div>
        <div class="col-md-6 text-end">
            <div class="time-filter">
                <a href="#" class="active">Aujourd'hui</a>
            </div>
        </div>
    </div>

    <!-- KPIs -->
    <div class="row mb-4">
        <!-- Commandes en cours -->
        <div class="col-md-4">
            <div class="stat-card primary">
                <div class="stat-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-number">{{ $commandesEnCours }}</div>
                <div class="stat-label">Commandes en cours</div>
                <div class="stat-trend trend-up">
                    <i class="fas fa-arrow-up"></i> +5% depuis hier
                </div>
            </div>
        </div>

        <!-- Commandes validées -->
        <div class="col-md-4">
            <div class="stat-card success">
                <div class="stat-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-number">{{ $commandesValidees }}</div>
                <div class="stat-label">Commandes validées</div>
                <div class="stat-trend trend-up">
                    <i class="fas fa-arrow-up"></i> +12% depuis hier
                </div>
            </div>
        </div>

        <!-- Recettes journalières -->
        <div class="col-md-4">
            <div class="stat-card warning">
                <div class="stat-icon">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
                <div class="stat-number">{{ number_format($recettesJournalieres, 0) }} FCFA</div>
                <div class="stat-label">Recettes journalières</div>
                <div class="stat-trend trend-up">
                    <i class="fas fa-arrow-up"></i> +8% depuis hier
                </div>
            </div>
        </div>
    </div>

    <!-- Graphiques -->
    <div class="row">
        <!-- Commandes par mois -->
        <div class="col-md-6 mb-4">
            <div class="chart-card">
                <div class="chart-header">
                    <h2 class="chart-title">Commandes par mois</h2>
                    <div class="chart-actions">
                        <button class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-download"></i>
                        </button>
                    </div>
                </div>
                <div class="chart-container">
                    <canvas id="commandesChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Livres vendus par catégorie -->
        <div class="col-md-6 mb-4">
            <div class="chart-card">
                <div class="chart-header">
                    <h2 class="chart-title">Livres vendus par catégorie</h2>
                    <div class="chart-actions">
                        <button class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-download"></i>
                        </button>
                    </div>
                </div>
                <div class="chart-container">
                    <canvas id="categoriesChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Configuration du graphique des commandes par mois
    const commandesCtx = document.getElementById('commandesChart').getContext('2d');

    const commandesChart = new Chart(commandesCtx, {
        type: 'bar',
        data: {
            labels: @json(array_values($moisLabels)),
            datasets: [{
                label: 'Nombre de commandes',
                data: @json(array_values($commandesData)),
                backgroundColor: 'rgba(52, 152, 219, 0.7)',
                borderColor: 'rgba(52, 152, 219, 1)',
                borderWidth: 1,
                borderRadius: 5,
                maxBarThickness: 40
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        display: true,
                        drawBorder: false,
                        color: 'rgba(0, 0, 0, 0.05)'
                    },
                    ticks: {
                        precision: 0
                    }
                },
                x: {
                    grid: {
                        display: false,
                        drawBorder: false
                    }
                }
            }
        }
    });

    // Configuration du graphique des livres vendus par catégorie
    const categoriesCtx = document.getElementById('categoriesChart').getContext('2d');

    // Générer des couleurs pour chaque catégorie
    const generateColors = (count) => {
        const colors = [
            'rgba(46, 204, 113, 0.7)',  // Vert
            'rgba(52, 152, 219, 0.7)',  // Bleu
            'rgba(155, 89, 182, 0.7)',  // Violet
            'rgba(241, 196, 15, 0.7)',  // Jaune
            'rgba(231, 76, 60, 0.7)',   // Rouge
            'rgba(230, 126, 34, 0.7)'   // Orange
        ];

        let result = [];
        for (let i = 0; i < count; i++) {
            result.push(colors[i % colors.length]);
        }
        return result;
    };

    const categories = @json($categories);
    const backgroundColors = generateColors(categories.length);
    const borderColors = backgroundColors.map(color => color.replace('0.7', '1'));

    // Préparer les datasets
    const datasets = categories.map((category, index) => {
        return {
            label: category,
            data: Object.values(@json($ventesParCategorie)[category]),
            backgroundColor: backgroundColors[index],
            borderColor: borderColors[index],
            borderWidth: 2,
            tension: 0.3,
            pointBackgroundColor: borderColors[index],
            pointRadius: 4,
            pointHoverRadius: 6
        };
    });

    const categoriesChart = new Chart(categoriesCtx, {
        type: 'line',
        data: {
            labels: @json(array_values($moisLabels)),
            datasets: datasets
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                mode: 'index',
                intersect: false
            },
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        boxWidth: 12,
                        padding: 15
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        display: true,
                        drawBorder: false,
                        color: 'rgba(0, 0, 0, 0.05)'
                    },
                    ticks: {
                        precision: 0
                    }
                },
                x: {
                    grid: {
                        display: false,
                        drawBorder: false
                    }
                }
            }
        }
    });
</script>
</body>
</html>
@endsection
