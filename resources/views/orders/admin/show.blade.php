<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Gestion commande #{{ $order->id }}
            </h2>
            <a
                href="{{ route('orders.admin.index') }}"
                class="text-sm font-medium text-gray-600 hover:text-gray-900"
            >
                Retour
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-6 rounded-md bg-green-50 p-4 text-sm text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            <div class="mb-6 rounded-md bg-white p-4 shadow-sm sm:rounded-lg">
                <div class="grid gap-2 text-sm text-gray-600">
                    <span><strong>Client:</strong> {{ $order->user->name ?? 'N/A' }} ({{ $order->user->email ?? '' }})</span>
                    <span><strong>Statut:</strong> {{ $order->status }}</span>
                    <span><strong>Total:</strong> {{ number_format($order->total_amount, 2) }} FCFA</span>
                    <span><strong>Date:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</span>
                </div>
            </div>

            <div class="mb-6 rounded-md bg-white p-4 shadow-sm sm:rounded-lg">
                <form method="POST" action="{{ route('orders.admin.status', $order) }}" class="flex flex-wrap items-center gap-3">
                    @csrf
                    @method('PATCH')
                    <label class="text-sm font-medium text-gray-700">Changer le statut</label>
                    <select name="status" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @foreach(['en_attente', 'en_preparation', 'prete', 'payee', 'annulee'] as $status)
                            <option value="{{ $status }}" @selected($order->status === $status)>{{ $status }}</option>
                        @endforeach
                    </select>
                    <button
                        type="submit"
                        class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-500"
                    >
                        Mettre à jour
                    </button>
                </form>

                <form method="POST" action="{{ route('orders.admin.cancel', $order) }}" class="mt-4">
                    @csrf
                    @method('PATCH')
                    <button
                        type="submit"
                        class="rounded-md bg-red-600 px-4 py-2 text-sm font-semibold text-white hover:bg-red-500"
                    >
                        Annuler la commande
                    </button>
                </form>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Burger</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Prix</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Quantité</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Total</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                @foreach($order->items as $item)
                                    <tr>
                                        <td class="px-4 py-3 font-medium text-gray-800">{{ $item->burger->name ?? 'Burger supprimé' }}</td>
                                        <td class="px-4 py-3 text-gray-600">{{ number_format($item->unit_price, 2) }} FCFA</td>
                                        <td class="px-4 py-3 text-gray-600">{{ $item->quantity }}</td>
                                        <td class="px-4 py-3 text-gray-600">{{ number_format($item->total_price, 2) }} FCFA</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
