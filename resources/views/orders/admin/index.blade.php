<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Gestion des commandes
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6 rounded-md bg-white p-4 shadow-sm sm:rounded-lg">
                <form method="GET" action="{{ route('orders.admin.index') }}" class="flex flex-wrap items-center gap-3">
                    <label class="text-sm font-medium text-gray-700">Filtrer paiements</label>
                    <select name="paid" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">Tous</option>
                        <option value="1" @selected(request('paid') === '1')>Payee</option>
                        <option value="0" @selected(request('paid') === '0')>Non payee</option>
                    </select>
                    <button
                        type="submit"
                        class="rounded-md bg-gray-800 px-4 py-2 text-sm font-semibold text-white hover:bg-gray-700"
                    >
                        Filtrer
                    </button>
                </form>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if($orders->isEmpty())
                        <p class="text-gray-500">Aucune commande pour le moment.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">N°</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Client</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Date</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Statut</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Total</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Paiement</th>
                                        <th class="px-4 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-500">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 bg-white">
                                    @foreach($orders as $order)
                                        <tr>
                                            <td class="px-4 py-3 font-medium text-gray-800">#{{ $order->id }}</td>
                                            <td class="px-4 py-3 text-gray-600">{{ $order->user->name ?? 'N/A' }}</td>
                                            <td class="px-4 py-3 text-gray-600">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                            <td class="px-4 py-3">
                                                <span class="rounded-full bg-blue-100 px-2 py-1 text-xs font-medium text-blue-700">
                                                    {{ $order->status }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-3 text-gray-600">{{ number_format($order->total_amount, 2) }} FCFA</td>
                                            <td class="px-4 py-3">
                                                @if($order->payment)
                                                    <span class="rounded-full bg-emerald-100 px-2 py-1 text-xs font-medium text-emerald-700">
                                                        Payee
                                                    </span>
                                                @else
                                                    <span class="rounded-full bg-gray-200 px-2 py-1 text-xs font-medium text-gray-700">
                                                        Non payee
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-4 py-3 text-right">
                                                <a
                                                    href="{{ route('orders.admin.show', $order) }}"
                                                    class="rounded-md bg-gray-100 px-3 py-1 text-sm text-gray-700 hover:bg-gray-200"
                                                >
                                                    Gérer
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
