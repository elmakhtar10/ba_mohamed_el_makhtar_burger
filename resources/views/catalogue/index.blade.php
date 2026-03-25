<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Catalogue des burgers
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6 rounded-md bg-white p-4 shadow-sm sm:rounded-lg">
                <form method="GET" action="{{ route('catalogue.index') }}" class="grid gap-4 sm:grid-cols-4">
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
                    @if($burgers->isEmpty())
                        <p class="text-gray-500">Aucun burger disponible.</p>
                    @else
                        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                            @foreach($burgers as $burger)
                                <div class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm">
                                    @if($burger->image_path)
                                        <img
                                            src="{{ asset('storage/' . $burger->image_path) }}"
                                            alt="{{ $burger->name }}"
                                            class="h-40 w-full rounded object-cover"
                                        >
                                    @endif
                                    <div class="mt-4 space-y-2">
                                        <h3 class="text-lg font-semibold text-gray-800">{{ $burger->name }}</h3>
                                        <p class="text-sm text-gray-600">{{ \Illuminate\Support\Str::limit($burger->description, 80) }}</p>
                                        <div class="flex items-center justify-between">
                                            <span class="text-sm font-semibold text-gray-800">{{ number_format($burger->price, 2) }} FCFA</span>
                                            <a
                                                href="{{ route('catalogue.show', $burger) }}"
                                                class="text-sm font-medium text-indigo-600 hover:text-indigo-800"
                                            >
                                                Voir détails
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
