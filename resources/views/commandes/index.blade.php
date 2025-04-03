@extends("nav")
@section("navbar")
    <!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>Commandes Enregistrées</title>
    <style>
        body {
            background-color: #f8f9fc;
            color: #5a5c69;
            font-family: 'Nunito', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            padding: 20px 0;
        }

        .card {
            border: none;
            border-radius: 0.35rem;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }

        .card-header {
            background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
            color: white;
            font-weight: 700;
            padding: 1rem 1.25rem;
            border-radius: 0.35rem 0.35rem 0 0;
        }

        .table {
            border-collapse: separate;
            border-spacing: 0;
        }

        .table thead th {
            background-color: #f8f9fc;
            border-top: none;
            color: #4e73df;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.03rem;
            padding: 1rem;
            border-bottom: 2px solid #e3e6f0;
        }

        .table tbody tr:hover {
            background-color: rgba(78, 115, 223, 0.05);
        }

        .btn-primary {
            background-color: #4e73df;
            border-color: #4e73df;
            box-shadow: 0 0.125rem 0.25rem 0 rgba(58, 59, 69, 0.2);
            transition: all 0.2s;
        }

        .btn-primary:hover {
            background-color: #2e59d9;
            border-color: #2e59d9;
            transform: translateY(-1px);
        }

        .btn-danger {
            background-color: #e74a3b;
            border-color: #e74a3b;
            box-shadow: 0 0.125rem 0.25rem 0 rgba(58, 59, 69, 0.2);
            transition: all 0.2s;
        }

        .btn-danger:hover {
            background-color: #d52a1a;
            border-color: #d52a1a;
            transform: translateY(-1px);
        }

        .book-image {
            height: 80px;
            width: 60px;
            object-fit: cover;
            border-radius: 4px;
            box-shadow: 0 0.125rem 0.25rem 0 rgba(58, 59, 69, 0.2);
            transition: transform 0.3s;
        }

        .book-image:hover {
            transform: scale(1.5);
            z-index: 1000;
        }

        .pagination {
            margin-top: 1.5rem;
            justify-content: center;
        }

        .alert-success {
            background-color: #1cc88a;
            border-color: #169b6b;
            color: white;
        }

        .stock-badge {
            padding: 0.35em 0.65em;
            font-size: 0.75em;
            font-weight: 700;
            border-radius: 0.25rem;
        }

        .stock-high {
            background-color: #1cc88a;
            color: white;
        }

        .stock-medium {
            background-color: #f6c23e;
            color: white;
        }

        .stock-low {
            background-color: #e74a3b;
            color: white;
        }

        .description-cell {
            max-width: 200px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .category-cell {
            max-width: 150px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .action-buttons {
            display: flex;
            gap: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row mb-4">
            <div class="col">
                <h1 class="display-5 fw-bold text-primary">
                    <i class="fas fa-clipboard-list me-2"></i>Toutes les commandes
                </h1>
            </div>
        </div>

        @if(session("success"))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{session("success")}}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Livre</th>
                            <th>Quantité</th>
                            <th>Total</th>
                            <th>Email Client</th>
                            <th>Statut</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($commandes as $commande)
                            <tr>
                                <td>{{ $commande->id }}</td>
                                <td>{{ $commande->livre->titre}}</td>
                                <td>{{ $commande->quantite }}</td>
                                <td>{{ number_format($commande->total, 0) }} FCFA</td>
                                <td>{{ $commande->email }}</td>
                                <td>
                                    <span class="badge bg-{{ $commande->statut == 'en_attente' ? 'warning' : ($commande->statut == 'annulée' ? 'danger' : 'success') }}">
                                        {{ $commande->statut }}
                                    </span>
                                </td>
                                <td>{{ $commande->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <a href="{{ route('DetailsCommande', $commande->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i> Détails
                                    </a>
                                    @if($commande->statut != 'annulée')
                                        <form action="{{ route('annuler', $commande->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir annuler cette commande?')">
                                                <i class="fas fa-times"></i> Annuler
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">Aucune commande trouvée.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center mt-4">
                    {{ $commandes->links() }}
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
@endsection
