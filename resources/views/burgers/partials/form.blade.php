@csrf

<div class="grid gap-6">
    <div>
        <label class="block text-sm font-medium text-gray-700">Nom</label>
        <input
            type="text"
            name="name"
            value="{{ old('name', $burger->name ?? '') }}"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
            required
        >
        @error('name')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="grid gap-6 sm:grid-cols-2">
        <div>
            <label class="block text-sm font-medium text-gray-700">Prix</label>
            <input
                type="number"
                step="0.01"
                min="0"
                name="price"
                value="{{ old('price', $burger->price ?? '') }}"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                required
            >
            @error('price')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Stock</label>
            <input
                type="number"
                min="0"
                name="stock"
                value="{{ old('stock', $burger->stock ?? 0) }}"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                required
            >
            @error('stock')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Description</label>
        <textarea
            name="description"
            rows="3"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
        >{{ old('description', $burger->description ?? '') }}</textarea>
        @error('description')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Image</label>
        <input
            type="file"
            name="image"
            accept="image/*"
            class="mt-1 block w-full text-sm text-gray-700"
        >
        @error('image')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror

        @if(!empty($burger?->image_path))
            <div class="mt-3">
                <p class="text-sm text-gray-500">Image actuelle :</p>
                <img
                    src="{{ asset('storage/' . $burger->image_path) }}"
                    alt="Burger"
                    class="mt-2 h-20 w-20 rounded object-cover"
                >
            </div>
        @endif
    </div>

    <div class="flex items-center gap-3">
        <button
            type="submit"
            class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500"
        >
            Enregistrer
        </button>
        <a
            href="{{ route('burgers.index') }}"
            class="text-sm font-medium text-gray-600 hover:text-gray-900"
        >
            Retour
        </a>
    </div>
</div>
