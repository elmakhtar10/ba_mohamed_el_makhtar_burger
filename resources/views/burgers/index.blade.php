<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Gestion des burgers
            </h2>
            <a
                href="{{ route('burgers.create') }}"
                class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500"
            >
                Ajouter un burger
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-6 rounded-md bg-green-50 p-4 text-sm text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if($burgers->isEmpty())
                        <p class="text-gray-500">Aucun burger pour le moment.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Image</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Nom</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Prix</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Stock</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Statut</th>
                                        <th class="px-4 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-500">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 bg-white">
                                    @foreach($burgers as $burger)
                                        <tr>
                                            <td class="px-4 py-3">
                                                @if($burger->image_path)
                                                    <img
                                                        src="{{ asset('storage/' . $burger->image_path) }}"
                                                        alt="{{ $burger->name }}"
                                                        class="h-12 w-12 rounded object-cover"
                                                    >
                                                @else
                                                    <div class="h-12 w-12 rounded bg-gray-100"></div>
                                                @endif
                                            </td>
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
                                                @if($burger->is_archived)
                                                    <span class="rounded-full bg-gray-200 px-2 py-1 text-xs font-medium text-gray-700">
                                                        Archivé
                                                    </span>
                                                @else
                                                    <span class="rounded-full bg-blue-100 px-2 py-1 text-xs font-medium text-blue-700">
                                                        Actif
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-4 py-3 text-right">
                                                <div class="flex justify-end gap-2">
                                                    <a
                                                        href="{{ route('burgers.edit', $burger) }}"
                                                        class="rounded-md bg-gray-100 px-3 py-1 text-sm text-gray-700 hover:bg-gray-200"
                                                    >
                                                        Modifier
                                                    </a>
                                                    <form method="POST" action="{{ route('burgers.archive', $burger) }}">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button
                                                            type="submit"
                                                            class="rounded-md bg-yellow-100 px-3 py-1 text-sm text-yellow-800 hover:bg-yellow-200"
                                                        >
                                                            {{ $burger->is_archived ? 'Restaurer' : 'Archiver' }}
                                                        </button>
                                                    </form>
                                                    <form method="POST" action="{{ route('burgers.destroy', $burger) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button
                                                            type="submit"
                                                            class="rounded-md bg-red-100 px-3 py-1 text-sm text-red-700 hover:bg-red-200"
                                                        >
                                                            Supprimer
                                                        </button>
                                                    </form>
                                                </div>
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
