<!DOCTYPE html>
<html>
<head>
    <title>Facture #{{ $commande->id }}</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .header { text-align: center; margin-bottom: 20px; }
        .info { margin-bottom: 30px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .total { font-weight: bold; text-align: right; }
    </style>
</head>
<body>
<div class="header">
    <h1>Facture #{{ $commande->id }}</h1>
    <p>Date: {{ now()->format('d/m/Y') }}</p>
</div>

<div class="info">
    <p><strong>Client:</strong> {{ $commande->email }}</p>
</div>

<table>
    <thead>
    <tr>
        <th>Livre</th>
        <th>Quantité</th>
        <th>Prix unitaire</th>
        <th>Total</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td> {{ $commande->livre->titre }}</td>
        <td>{{ $commande->quantite }}</td>
        <td>{{ number_format($commande->livre->prix, 0) }} FCFA</td>
        <td>{{ number_format($commande->total, 0) }} FCFA</td>
    </tr>
    </tbody>
</table>

<div class="total">
    <p>Total: {{ number_format($commande->total, 0) }} FCFA</p>
</div>
</body>
</html>
