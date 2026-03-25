<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Confirmation commande</title>
</head>
<body style="margin:0; padding:0; background:#f6f6f6; font-family: Arial, sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background:#f6f6f6; padding:24px 0;">
        <tr>
            <td align="center">
                <table width="560" cellpadding="0" cellspacing="0" style="background:#ffffff; border-radius:12px; overflow:hidden;">
                    <tr>
                        <td style="padding:24px; background:#f59e0b; color:#111111;">
                            <h1 style="margin:0; font-size:20px;">ISI BURGER</h1>
                            <p style="margin:4px 0 0; font-size:12px;">Confirmation de commande</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:24px;">
                            <h2 style="margin:0 0 8px; font-size:18px; color:#111111;">Bonjour {{ $order->user->name ?? 'Client' }},</h2>
                            <p style="margin:0 0 12px; color:#555555;">
                                Votre commande <strong>#{{ $order->id }}</strong> a bien été enregistrée.
                            </p>
                            <p style="margin:0 0 18px; color:#555555;">
                                Total à payer : <strong>{{ number_format($order->total_amount, 2) }} FCFA</strong>
                            </p>

                            <a href="{{ route('orders.index') }}"
                               style="display:inline-block; background:#111111; color:#ffffff; text-decoration:none; padding:12px 18px; border-radius:8px; font-size:14px;">
                                Consulter mes commandes
                            </a>

                            <p style="margin:18px 0 0; font-size:12px; color:#777777;">
                                Merci pour votre confiance.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
