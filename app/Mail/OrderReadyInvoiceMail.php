<?php

namespace App\Mail;

use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderReadyInvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(public Order $order)
    {
        $this->order->loadMissing('items.burger', 'user');
    }

    public function build(): self
    {
        $pdf = Pdf::loadView('pdfs.invoice', [
            'order' => $this->order,
        ]);

        return $this
            ->subject('Votre commande est prete - Facture')
            ->view('emails.order-ready-invoice', [
                'order' => $this->order,
            ])
            ->attachData(
                $pdf->output(),
                'facture-commande-' . $this->order->id . '.pdf',
                ['mime' => 'application/pdf']
            );
    }
}
