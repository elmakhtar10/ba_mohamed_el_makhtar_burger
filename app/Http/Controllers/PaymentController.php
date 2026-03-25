<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class PaymentController extends Controller
{
    public function store(Request $request, Order $order)
    {
        if ($order->status === 'annulee') {
            throw ValidationException::withMessages([
                'payment' => 'La commande est annulée.',
            ]);
        }

        if ($order->payment) {
            throw ValidationException::withMessages([
                'payment' => 'Cette commande est déjà payée.',
            ]);
        }

        $data = $request->validate([
            'amount' => ['required', 'numeric', 'min:0'],
        ]);

        if ((float) $data['amount'] != (float) $order->total_amount) {
            throw ValidationException::withMessages([
                'amount' => 'Le montant doit être égal au total de la commande.',
            ]);
        }

        DB::transaction(function () use ($order, $data) {
            Payment::create([
                'order_id' => $order->id,
                'recorded_by' => auth()->id(),
                'amount' => $data['amount'],
                'paid_at' => now(),
            ]);

            $order->update(['status' => 'payee']);
        });

        return redirect()->route('orders.admin.show', $order)->with('success', 'Paiement enregistré.');
    }

    public function receipt(Order $order)
    {
        $order->load('payment', 'items.burger', 'user');

        if (! $order->payment) {
            abort(404);
        }

        $pdf = Pdf::loadView('pdfs.payment-receipt', [
            'order' => $order,
            'payment' => $order->payment,
        ]);

        return $pdf->download('recu-paiement-commande-' . $order->id . '.pdf');
    }
}
