<x-guest-layout>
    <div class="mb-6">
        <h1 class="text-2xl font-semibold">Creation de compte</h1>
        <p class="mt-1 text-sm text-white/60">Inscrivez-vous pour commander vos burgers.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <div>
            <label for="name" class="text-sm font-medium text-white/80">Nom complet</label>
            <input
                id="name"
                name="name"
                type="text"
                value="{{ old('name') }}"
                required
                autofocus
                autocomplete="name"
                class="mt-2 w-full rounded-lg border border-white/20 bg-white/5 px-3 py-2 text-sm text-white placeholder-white/40 focus:border-amber-400 focus:outline-none focus:ring-2 focus:ring-amber-400/30"
            >
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div>
            <label for="email" class="text-sm font-medium text-white/80">Email</label>
            <input
                id="email"
                name="email"
                type="email"
                value="{{ old('email') }}"
                required
                autocomplete="username"
                class="mt-2 w-full rounded-lg border border-white/20 bg-white/5 px-3 py-2 text-sm text-white placeholder-white/40 focus:border-amber-400 focus:outline-none focus:ring-2 focus:ring-amber-400/30"
            >
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <label for="password" class="text-sm font-medium text-white/80">Mot de passe</label>
            <input
                id="password"
                name="password"
                type="password"
                required
                autocomplete="new-password"
                class="mt-2 w-full rounded-lg border border-white/20 bg-white/5 px-3 py-2 text-sm text-white placeholder-white/40 focus:border-amber-400 focus:outline-none focus:ring-2 focus:ring-amber-400/30"
            >
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div>
            <label for="password_confirmation" class="text-sm font-medium text-white/80">Confirmer le mot de passe</label>
            <input
                id="password_confirmation"
                name="password_confirmation"
                type="password"
                required
                autocomplete="new-password"
                class="mt-2 w-full rounded-lg border border-white/20 bg-white/5 px-3 py-2 text-sm text-white placeholder-white/40 focus:border-amber-400 focus:outline-none focus:ring-2 focus:ring-amber-400/30"
            >
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <button type="submit" class="w-full rounded-lg bg-amber-500 px-4 py-2 text-sm font-semibold text-black hover:bg-amber-400">
            Creer mon compte
        </button>
    </form>

    <p class="mt-6 text-center text-sm text-white/60">
        Deja inscrit ?
        <a href="{{ route('login') }}" class="font-semibold text-amber-300 hover:text-amber-200">Se connecter</a>
    </p>
</x-guest-layout>
