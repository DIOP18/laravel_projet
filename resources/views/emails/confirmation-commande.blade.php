<!DOCTYPE html>
<html>
<head>
    <title>Confirmation de commande</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background-color: #f8f9fa; padding: 20px; text-align: center; }
        .content { padding: 20px; }
        .footer { margin-top: 20px; text-align: center; font-size: 12px; color: #6c757d; }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h2>Merci pour votre commande !</h2>
    </div>

    <div class="content">
        <p>Bonjour,</p>

        <p>Nous avons bien reçu votre commande :</p>
        <ul>
            <li><strong>Livre :</strong> {{ $commande->livre->titre }}</li>
            <li><strong>Auteur :</strong> {{ $commande->livre->auteur }}</li>
            <li><strong>Quantité :</strong> {{ $commande->quantite }}</li>
            <li><strong>Prix unitaire :</strong> {{ number_format($commande->livre->prix ?? 0, 0) }} FCFA</li>
            <li><strong>TOTAL : </strong>{{number_format($commande->total)}}</li>
        </ul>

        <p>Nous traiterons votre commande dans les plus brefs délais.</p>
    </div>

    <div class="footer">
        <p>© {{ date('Y') }} MISSTECH LIBRAIRIE. Tous droits réservés.</p>
    </div>
</div>
</body>
</html>
