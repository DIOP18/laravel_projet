@extends('nav')
@section('navbar')

    <!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>Details Livres</title>
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
@if(session("error"))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>{{session("error")}}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
@if(session("success"))
    <div class="alert alert-primary alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>{{session("success")}}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif


<div class="container py-5">
    <div class="row">
        <div class="col-md-4">
            <img src="{{ asset('storage/'.$livre->image) }}" class="img-fluid rounded" alt="{{ $livre->titre }}">
        </div>
        <div class="col-md-8">
            <h1>{{ $livre->titre }}</h1>
            <p class="text-muted">Par {{ $livre->auteur }}</p>

            <div class="d-flex align-items-center mb-3">
                <span class="badge bg-primary me-2">{{ $livre->categorie }}</span>
                <h4 class="text-success mb-0">{{ number_format($livre->prix, 0) }} FCFA</h4>

            </div>

            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Description</h5>
                </div>
                <div class="card-body">
                    <p>{{ $livre->description }}</p>
                </div>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('catalogue') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Retour au catalogue
                </a>
                <button class="btn btn-success commander-btn" data-livre-id="{{ $livre->id }}">
                    <i class="fas fa-shopping-cart"></i> Commander
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="commandeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="commandeForm" method="POST" action="{{ route('commande') }}">
                @csrf
                <input type="hidden" name="livre_id" value="{{ $livre->id }}">
                <div class="modal-header">
                    <h5 class="modal-title">Commander "{{ $livre->titre }}"</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Quantité</label>
                        <input type="number" name="quantite" class="form-control" min="1" value="1" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Votre email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Confirmer la commande</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const commanderBtn = document.querySelector('.commander-btn');
        commanderBtn.addEventListener('click', function() {
            const modal = new bootstrap.Modal(document.getElementById('commandeModal'));
            modal.show();
        });
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

@endsection
