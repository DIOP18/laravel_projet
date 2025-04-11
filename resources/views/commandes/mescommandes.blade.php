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

    </style>
</head>
<body>
    <div class="container py-5">
        <div class="card shadow-sm">
            <div class="card-header bg-light py-3">
                @if(session("paiement"))
                    <div class="alert alert-primary alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>{{session("paiement")}}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
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
                                <th>Action</th>
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
                                            'expedie'=>'success',
                                            default => 'warning'
                                        }
                                    }}">
                                        {{ ucfirst($commande->statut) }}
                                    </span>
                                    </td>
                                    <td class="text-success fw-bold">
                                        {{ number_format($commande->total, 0) }} FCFA
                                    </td>
                                    <td>
                                        @if($commande->statut == 'en_attente')
                                            <button class="btn btn-success btn-sm pay-button" data-commande-id="{{ $commande->id }}">
                                                <i class="fas fa-cash-register me-1"></i>payee
                                            </button>
                                        @else
                                            <button class="btn btn-secondary btn-sm" disabled>
                                                <i class="fas fa-check-circle me-1"></i>payee
                                            </button>
                                        @endif
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

    <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="paymentModalLabel"><i class="fas fa-credit-card me-2"></i>Choisir un mode de paiement</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="paymentForm" action="{{ route('paymentMethod') }}" method="POST">
                        @csrf
                        <input type="hidden" name="commande_id" id="commande_id" value="">

                        <div class="mb-4">
                            <label class="form-label fw-bold">Mode de paiement</label>
                            <div class="payment-options">
                                <div class="form-check payment-option border rounded p-3 mb-3">
                                    <input class="form-check-input" type="radio" name="payment_method" id="espece" value="espece" checked>
                                    <label class="form-check-label w-100" for="espece">
                                        <div class="d-flex align-items-center">
                                            <div class="payment-icon bg-success bg-opacity-10 p-2 rounded me-3">
                                                <i class="fas fa-money-bill-wave text-success fa-2x"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-1">Espèce (Prioritaire)</h6>
                                                <small class="text-muted">Paiement en espèces lors de la livraison!</small>
                                            </div>
                                        </div>
                                    </label>
                                </div>

                                <div class="form-check payment-option border rounded p-3">
                                    <input class="form-check-input" type="radio" name="payment_method" id="carte" value="carte">
                                    <label class="form-check-label w-100" for="carte">
                                        <div class="d-flex align-items-center">
                                            <div class="payment-icon bg-primary bg-opacity-10 p-2 rounded me-3">
                                                <i class="fas fa-credit-card text-primary fa-2x"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-1">Carte bancaire</h6>
                                                <small class="text-muted">Paiement sécurisé par carte bancaire</small>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer px-0 pb-0">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-check-circle me-2"></i>Confirmer le paiement
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Remplacez votre script existant par celui-ci -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Récupérer tous les boutons de paiement
            const payButtons = document.querySelectorAll('.pay-button');

            // Ajouter un événement de clic à chaque bouton
            payButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Récupérer l'ID de la commande
                    const commandeId = this.getAttribute('data-commande-id');

                    // Mettre à jour l'ID de la commande dans le formulaire modal
                    document.getElementById('commande_id').value = commandeId;
                    console.log('ID de commande défini:', commandeId);

                    // Afficher le modal
                    const paymentModal = new bootstrap.Modal(document.getElementById('paymentModal'));
                    paymentModal.show();
                });
            });

            // Style supplémentaire pour les options de paiement
            const paymentOptions = document.querySelectorAll('.payment-option');
            paymentOptions.forEach(option => {
                const radio = option.querySelector('input[type="radio"]');

                // Ajouter une classe lorsque l'option est sélectionnée
                radio.addEventListener('change', function() {
                    paymentOptions.forEach(opt => {
                        opt.classList.remove('border-primary');
                    });

                    if (this.checked) {
                        option.classList.add('border-primary');
                    }
                });

                // Initialiser le style pour l'option par défaut
                if (radio.checked) {
                    option.classList.add('border-primary');
                }

                // Permettre de cliquer sur toute la zone pour sélectionner l'option
                option.addEventListener('click', function() {
                    radio.checked = true;

                    // Déclencher l'événement change pour appliquer le style
                    const event = new Event('change');
                    radio.dispatchEvent(event);
                });
            });

            // Ajout d'une journalisation pour le formulaire
            document.getElementById('paymentForm').addEventListener('submit', function(event) {
                console.log('Formulaire soumis avec commande_id:', document.getElementById('commande_id').value);
                console.log('Mode de paiement:', document.querySelector('input[name="payment_method"]:checked').value);
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
@endsection
