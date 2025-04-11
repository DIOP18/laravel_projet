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
                @if(session("livraison"))
                    <div class="alert alert-primary alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>{{session("livraison")}}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <h1 class="display-5 fw-bold text-primary">
                    <i class="fas fa-clipboard-check me-2"></i>Détails de la commande #{{ $commande->id }}
                </h1>
                <a href="{{ route('index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Retour à la liste des commandes
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">Informations de la commande</h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <p><strong>ID de commande:</strong> #{{ $commande->id }}</p>
                                <p><strong>Date:</strong> {{ $commande->created_at->format('d/m/Y H:i') }}</p>
                                <p><strong>Email du client:</strong> {{ $commande->email }}</p>
                            </div>
                            <div class="col-md-6">
                                <p>
                                    <strong>Statut:</strong>
                                    <span class="badge bg-{{ $commande->statut == 'en_attente' ? 'warning' : ($commande->statut == 'annulée' ? 'danger' : 'success') }}">
                                    {{ $commande->statut }}
                                </span>
                                </p>
                                <p><strong>Quantité:</strong> {{ $commande->quantite }}</p>
                                <p><strong>Total:</strong> {{ number_format($commande->total, 0) }} FCFA</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">Détails du livre</h5>
                    </div>
                    <div class="card-body">
                        @if($commande->livre)
                            <div class="row">
                                <div class="col-md-4">
                                    <img src="{{ asset('storage/' . ($commande->livre->image)) }}"
                                         alt="{{ $commande->livre->titre ?? 'Livre indisponible' }}"
                                         class="img-fluid rounded">
                                </div>
                                <div class="col-md-8">
                                    <h4>{{ $commande->livre->titre }}</h4>
                                    <p><strong>Auteur:</strong> {{ $commande->livre->auteur }}</p>
                                    <p><strong>Catégorie:</strong> {{ $commande->livre->categorie }}</p>
                                    <p><strong>Prix unitaire:</strong> {{ number_format($commande->livre->prix, 0) }} FCFA</p>
                                    <p><strong>Stock actuel:</strong> {{ $commande->livre->Stockdisponible }}</p>
                                </div>
                            </div>
                        @else
                            <p class="text-danger">Les informations du livre ne sont plus disponibles.</p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">Actions</h5>
                    </div>
                    <div class="card-body">
                        @if($commande->statut === 'en_attente')
                            <form action="{{ route('annuler', $commande->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger w-100 mb-3" onclick="return confirm('Êtes-vous sûr de vouloir annuler cette commande?')">
                                    <i class="fas fa-times me-2"></i>Annuler la commande
                                </button>
                            </form>
                        @elseif($commande->statut === 'payee')
                            <form action="{{ route('expedier', $commande->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-info w-100 mb-3">
                                    <i class="fas fa-envelope me-2"></i>Expédier la commande
                                </button>
                            </form>
                        @elseif($commande->statut === 'annulée')
                            <div class="alert alert-danger mb-3">
                                <i class="fas fa-ban me-2"></i>Commande annulée le {{ $commande->updated_at->format('d/m/Y H:i') }}
                            </div>
                        @else
                            <div class="alert alert-success mb-3">
                                <i class="fas fa-envelope me-2"></i>COMMANDE EXPEDIEEEE
                            </div>
                        @endif



                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
@endsection
