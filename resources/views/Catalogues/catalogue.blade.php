@extends('nav')
@section('navbar')

    <!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>Gestion de Livres</title>
    <style>
        .book-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .book-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
        }
        .pagination {
            --bs-pagination-active-bg: #0d6efd;
            --bs-pagination-active-border-color: #0d6efd;
        }
    </style>
</head>
    <body>
    <div class="container py-5">
        <div class="row mb-4">
            <div class="col">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h1 class="display-5 fw-bold text-primary">
                        <i class="fas fa-book-open me-2"></i>Catalogue des Livres
                    </h1>
                    <a href="" class="btn btn-primary btn-lg">
                        <i class="fas fa-clipboard-list me-2"></i>Mes Commandes
                    </a>
                </div>
                <p class="text-muted lead">Découvrez notre sélection de livres et filtrez selon vos préférences</p>

        <!-- Filtres avec design amélioré -->
        <div class="card mb-5 border-0 shadow-sm">
            <div class="card-header bg-light py-3">
                <h5 class="mb-0"><i class="fas fa-filter me-2"></i>Filtres de recherche</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('catalogue') }}" method="GET">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Auteur</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                <input type="text" name="auteur" class="form-control" placeholder="Nom de l'auteur" value="{{ request('auteur') }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Catégorie</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-tag"></i></span>
                                <select name="categorie" class="form-select">
                                    <option value="">Toutes les catégories</option>
                                    @foreach($categories as $categorie)
                                        <option value="{{ $categorie }}" {{ request('categorie') == $categorie ? 'selected' : '' }}>
                                            {{ $categorie }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Prix min</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-coins"></i></span>
                                <input type="number" name="prix_min" class="form-control" placeholder="0" value="{{ request('prix_min') }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Prix max</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-coins"></i></span>
                                <input type="number" name="prix_max" class="form-control" placeholder="100,000" value="{{ request('prix_max') }}">
                            </div>
                        </div>
                        <div class="col-12 mt-4">
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="fas fa-search me-2"></i> Rechercher
                                </button>
                                <a href="{{ route('catalogue') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-times me-2"></i> Réinitialiser
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Liste des livres avec design moderne -->
        <div class="row">
            @foreach($livres as $livre)
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card h-100 border-0 shadow-sm book-card">
                        <div class="position-relative">
                            <img src="{{ asset('storage/'.$livre->image) }}" class="card-img-top" alt="{{ $livre->titre }}" style="height: 250px; object-fit: cover;">
                            <span class="badge bg-primary position-absolute top-0 end-0 m-2">{{ $livre->categorie }}</span>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title fw-bold">{{ $livre->titre }}</h5>
                            <p class="text-muted mb-3"><i class="fas fa-user-edit me-1"></i> {{ $livre->auteur }}</p>
                            <h5 class="text-success fw-bold mb-3">
                                <i class="fas fa-tag me-1"></i> {{ number_format($livre->prix, 0) }} FCFA
                            </h5>
                            <div class="d-grid gap-2">
                                <a href="{{ route('showDetails', $livre->id) }}" class="btn btn-outline-primary">
                                    <i class="fas fa-eye me-1"></i> Voir les détails
                                </a>
                                <button class="btn btn-success commander-btn" data-livre-id="{{ $livre->id }}">
                                    <i class="fas fa-shopping-cart me-1"></i> Ajouter au panier
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Message si aucun livre trouvé -->
        @if(count($livres) === 0)
            <div class="alert alert-info text-center py-5 mt-4">
                <i class="fas fa-info-circle fa-3x mb-3"></i>
                <h4>Aucun livre ne correspond à vos critères</h4>
                <p>Essayez de modifier vos filtres de recherche.</p>
            </div>
        @endif

        <!-- Pagination améliorée -->
        <div class="d-flex justify-content-center mt-5">
            {{ $livres->links() }}
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        </div>
    </div>

    </body>

</html>
@endsection
