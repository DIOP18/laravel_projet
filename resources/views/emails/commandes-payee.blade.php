<!doctype html>
<html lang="en">
<head>
    <title>Confirmation de Paiemmentt </title>
</head>
<body>
<div class="container">
    <div class="header">
    </div>

    <div class="content">
       <p>Le client {{ $commande->email }} a payé sa commande.</p>

        <p>Détails du paiement :</p>
        <ul>
            <li><strong>ID de commande :</strong> {{ $commande->id }}</li>
            <li><strong>Livre :</strong> {{ $commande->livre->titre }}</li>
            <li><strong>Quantité :</strong> {{ $commande->quantite }}</li>
            <li><strong>Mode de paiement :</strong> {{ $commande->payment_method == 'espece' ? 'Espèce' : 'Carte bancaire' }}</li>
            <li><strong>Date de paiement :</strong> {{ $commande->payment_date->format('d/m/Y H:i') }}</li>
            <li><strong>TOTAL :</strong> {{ number_format($commande->total, 0) }} FCFA</li>
        </ul>

        <p>Veuillez procéder à la livraison de cette commande dès que possible.</p>
    </div>
</div>

</body>
</html>
