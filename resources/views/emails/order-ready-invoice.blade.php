<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Commande prête</title>
</head>
<body>
    <h1 style="font-size: 20px; font-weight: 600;">Votre commande est prête</h1>
    <p style="margin-top: 8px;">Bonjour {{ $order->user->name ?? 'Client' }},</p>
    <p style="margin-top: 8px;">
        Votre commande #{{ $order->id }} est prête. Vous trouverez la facture en pièce jointe.
    </p>
    <p style="margin-top: 12px;">Merci pour votre confiance.</p>
</body>
</html>
