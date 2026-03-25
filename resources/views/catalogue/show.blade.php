<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Détails du burger
            </h2>
            <a
                href="{{ route('catalogue.index') }}"
                class="text-sm font-medium text-gray-600 hover:text-gray-900"
            >
                Retour
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="grid gap-6 md:grid-cols-2">
                        <div>
                            @if($burger->image_path)
                                <img
                                    src="{{ asset('storage/' . $burger->image_path) }}"
                                    alt="{{ $burger->name }}"
                                    class="h-64 w-full rounded object-cover"
                                >
                            @endif
                        </div>
                        <div class="space-y-3">
                            <h3 class="text-2xl font-semibold text-gray-800">{{ $burger->name }}</h3>
                            <p class="text-gray-600">{{ $burger->description }}</p>
                            <p class="text-sm text-gray-500">Stock: {{ $burger->stock }}</p>
                            <p class="text-lg font-semibold text-gray-900">{{ number_format($burger->price, 2) }} FCFA</p>
                            <a
                                href="{{ route('orders.create') }}"
                                class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500"
                            >
                                Commander
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
