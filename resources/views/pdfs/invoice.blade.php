<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Facture - Commande #{{ $order->id }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #111; }
        .header { margin-bottom: 20px; }
        .title { font-size: 18px; font-weight: bold; }
        .info { margin-top: 6px; }
        table { width: 100%; border-collapse: collapse; margin-top: 16px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background: #f3f3f3; }
        .total { text-align: right; margin-top: 12px; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">Facture - ISI BURGER</div>
        <div class="info">Commande #{{ $order->id }}</div>
        <div class="info">Client: {{ $order->user->name ?? 'Client' }} ({{ $order->user->email ?? '' }})</div>
        <div class="info">Date: {{ $order->created_at->format('d/m/Y H:i') }}</div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Burger</th>
                <th>Prix</th>
                <th>Quantité</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
                <tr>
                    <td>{{ $item->burger->name ?? 'Burger supprimé' }}</td>
                    <td>{{ number_format($item->unit_price, 2) }} FCFA</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format($item->total_price, 2) }} FCFA</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total">
        Total à payer: {{ number_format($order->total_amount, 2) }} FCFA
    </div>
</body>
</html>
