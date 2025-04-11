<!DOCTYPE html>
<html>
<head>
    <title>Commande Expédiée</title>
</head>
<body>
<h1>Votre commande a été expédiée</h1>
<p>Bonjour,</p>

<p>Nous vous informons que votre commande #{{ $commande->id }} a été expédiée.</p>

<h2>Détails de la commande :</h2>
<ul>
    <li>Livre: {{ $commande->livre->titre }}</li>
    <li>Quantité: {{ $commande->quantite }}</li>
    <li>Total: {{ number_format($commande->total, 0) }} FCFA</li>
</ul>

<p>Vous trouverez ci-joint votre facture au format PDF.</p>

<p>Cordialement,<br>
    L'équipe de votre librairie</p>
</body>
</html>
