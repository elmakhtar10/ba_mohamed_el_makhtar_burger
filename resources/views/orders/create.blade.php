<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Passer une commande
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6 rounded-md bg-white p-4 shadow-sm sm:rounded-lg">
                <form method="GET" action="{{ route('orders.create') }}" class="grid gap-4 sm:grid-cols-4">
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Nom du burger"
                        class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    >
                    <input
                        type="number"
                        step="0.01"
                        min="0"
                        name="min_price"
                        value="{{ request('min_price') }}"
                        placeholder="Prix min"
                        class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    >
                    <input
                        type="number"
                        step="0.01"
                        min="0"
                        name="max_price"
                        value="{{ request('max_price') }}"
                        placeholder="Prix max"
                        class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    >
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
                    @if($errors->has('items'))
                        <div class="mb-4 rounded-md bg-red-50 p-3 text-sm text-red-600">
                            {{ $errors->first('items') }}
                        </div>
                    @endif

                    @if($burgers->isEmpty())
                        <p class="text-gray-500">Aucun burger trouvé.</p>
                    @else
                        <form method="POST" action="{{ route('orders.store') }}">
                            @csrf

                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Burger</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Prix</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Stock</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Quantité</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 bg-white">
                                        @foreach($burgers as $burger)
                                            <tr>
                                                <td class="px-4 py-3 font-medium text-gray-800">{{ $burger->name }}</td>
                                                <td class="px-4 py-3 text-gray-600">{{ number_format($burger->price, 2) }} FCFA</td>
                                                <td class="px-4 py-3">
                                                    @if($burger->stock > 0)
                                                        <span class="rounded-full bg-green-100 px-2 py-1 text-xs font-medium text-green-700">
                                                            {{ $burger->stock }}
                                                        </span>
                                                    @else
                                                        <span class="rounded-full bg-red-100 px-2 py-1 text-xs font-medium text-red-700">
                                                            Rupture
                                                        </span>
                                                    @endif
                                                </td>
                                                <td class="px-4 py-3">
                                                    <input
                                                        type="number"
                                                        min="0"
                                                        name="items[{{ $burger->id }}]"
                                                        value="{{ old('items.' . $burger->id, 0) }}"
                                                        class="w-24 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                                        {{ $burger->stock === 0 ? 'disabled' : '' }}
                                                    >
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-6 flex items-center gap-3">
                                <button
                                    type="submit"
                                    class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500"
                                >
                                    Valider la commande
                                </button>
                                <a
                                    href="{{ route('orders.index') }}"
                                    class="text-sm font-medium text-gray-600 hover:text-gray-900"
                                >
                                    Retour
                                </a>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
