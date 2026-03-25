<?php

namespace App\Http\Controllers;

use App\Models\Burger;
use App\Models\Order;
use App\Models\OrderItem;
use App\Mail\OrderReadyInvoiceMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class OrderController extends Controller
{
    private const STATUSES = [
        'en_attente',
        'en_preparation',
        'prete',
        'payee',
        'annulee',
    ];

    public function index()
    {
        $orders = Order::with('items')
            ->where('user_id', auth()->id())
            ->orderByDesc('created_at')
            ->get();

        return view('orders.index', compact('orders'));
    }

    public function create(Request $request)
    {
        $query = Burger::query()->where('is_archived', false);

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->string('search') . '%');
        }

        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->input('min_price'));
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->input('max_price'));
        }

        $burgers = $query->orderBy('name')->get();

        return view('orders.create', compact('burgers'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'items' => ['required', 'array'],
            'items.*' => ['nullable', 'integer', 'min:0'],
        ]);

        $items = collect($data['items'])
            ->filter(fn ($qty) => (int) $qty > 0)
            ->mapWithKeys(fn ($qty, $id) => [(int) $id => (int) $qty]);

        if ($items->isEmpty()) {
            throw ValidationException::withMessages([
                'items' => 'Veuillez choisir au moins un burger.',
            ]);
        }

        DB::transaction(function () use ($items) {
            $order = Order::create([
                'user_id' => auth()->id(),
                'status' => 'en_attente',
                'total_amount' => 0,
            ]);

            $total = 0;
            $burgers = Burger::whereIn('id', $items->keys())->lockForUpdate()->get();

            foreach ($items as $burgerId => $quantity) {
                $burger = $burgers->firstWhere('id', $burgerId);

                if (! $burger || $burger->is_archived) {
                    throw ValidationException::withMessages([
                        'items' => 'Un des burgers selectionnes est invalide.',
                    ]);
                }

                if ($burger->stock < $quantity) {
                    throw ValidationException::withMessages([
                        'items' => "Stock insuffisant pour {$burger->name}.",
                    ]);
                }

                $lineTotal = $burger->price * $quantity;
                $total += $lineTotal;

                OrderItem::create([
                    'order_id' => $order->id,
                    'burger_id' => $burger->id,
                    'quantity' => $quantity,
                    'unit_price' => $burger->price,
                    'total_price' => $lineTotal,
                ]);

                $burger->decrement('stock', $quantity);
            }

            $order->update(['total_amount' => $total]);
        });

        return redirect()->route('orders.index')->with('success', 'Commande enregistree avec succes.');
    }

    public function show(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $order->load('items.burger');

        return view('orders.show', compact('order'));
    }

    public function adminIndex()
    {
        $orders = Order::with('user')
            ->orderByDesc('created_at')
            ->get();

        return view('orders.admin.index', compact('orders'));
    }

    public function adminShow(Order $order)
    {
        $order->load('items.burger', 'user');

        return view('orders.admin.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $data = $request->validate([
            'status' => ['required', 'string', 'in:' . implode(',', self::STATUSES)],
        ]);

        $previousStatus = $order->status;
        $order->update(['status' => $data['status']]);

        if ($previousStatus !== 'prete' && $data['status'] === 'prete') {
            Mail::to($order->user?->email)->send(new OrderReadyInvoiceMail($order));
        }

        return redirect()->route('orders.admin.show', $order)->with('success', 'Statut mis a jour.');
    }

    public function cancel(Order $order)
    {
        if ($order->status === 'annulee') {
            return redirect()->route('orders.admin.show', $order);
        }

        DB::transaction(function () use ($order) {
            $order->load('items.burger');

            foreach ($order->items as $item) {
                if ($item->burger) {
                    $item->burger->increment('stock', $item->quantity);
                }
            }

            $order->update(['status' => 'annulee']);
        });

        return redirect()->route('orders.admin.show', $order)->with('success', 'Commande annulee.');
    }
}
