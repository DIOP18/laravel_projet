@extends("nav")
@section("navbar")
    <!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>Details Commandes</title>
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
    <div class="container py-5">
        <div class="card shadow-sm">
            <div class="card-header bg-light py-3">
                <h3 class="mb-0">
                    <i class="fas fa-history me-2"></i>
                    Mes Commandes ({{ auth()->user()->name }})
                </h3>
            </div>

            <div class="card-body">
                @if($commandes->isEmpty())
                    <div class="text-center py-5">
                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                        <h4>Aucune commande trouvée</h4>
                        <p>Vous n'avez pas encore passé de commande.</p>
                        <a href="{{ route('catalogue') }}" class="btn btn-primary">
                            <i class="fas fa-book-open me-2"></i>Voir le catalogue
                        </a>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                            <tr>
                                <th>Date</th>

                                <th>Livre</th>
                                <th>Statut</th>
                                <th>Total</th>

                            </tr>
                            </thead>
                            <tbody>
                            @foreach($commandes as $commande)
                                <tr>
                                    <td>{{ $commande->created_at->format('d/m/Y H:i') }}</td>

                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset('storage/'.$commande->livre->image) }}"
                                                 class="rounded me-3"
                                                 width="60"
                                                 alt="{{ $commande->livre->titre }}">
                                            <div>
                                                <h6 class="mb-1">{{ $commande->livre->titre }}</h6>
                                                <small class="text-muted">{{ $commande->livre->auteur }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                    <span class="badge bg-{{
                                        match($commande->statut) {
                                            'payee' => 'success',
                                            'annulee' => 'danger',
                                            default => 'warning'
                                        }
                                    }}">
                                        {{ ucfirst($commande->statut) }}
                                    </span>
                                    </td>
                                    <td class="text-success fw-bold">
                                        {{ number_format($commande->total, 0) }} FCFA
                                    </td>

                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                        {{ $commandes->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
@endsection
