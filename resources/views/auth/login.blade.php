<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="mb-6">
        <h1 class="text-2xl font-semibold">Connexion</h1>
        <p class="mt-1 text-sm text-white/60">Accedez au catalogue et a vos commandes.</p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <div>
            <label for="email" class="text-sm font-medium text-white/80">Email</label>
            <input
                id="email"
                name="email"
                type="email"
                value="{{ old('email') }}"
                required
                autofocus
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
                autocomplete="current-password"
                class="mt-2 w-full rounded-lg border border-white/20 bg-white/5 px-3 py-2 text-sm text-white placeholder-white/40 focus:border-amber-400 focus:outline-none focus:ring-2 focus:ring-amber-400/30"
            >
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between">
            <label class="inline-flex items-center gap-2 text-sm text-white/70">
                <input id="remember_me" type="checkbox" name="remember" class="h-4 w-4 rounded border-white/20 bg-white/5 text-amber-500 focus:ring-amber-400/30">
                Se souvenir de moi
            </label>
            @if (Route::has('password.request'))
                <a class="text-sm text-amber-300 hover:text-amber-200" href="{{ route('password.request') }}">
                    Mot de passe oublie ?
                </a>
            @endif
        </div>

        <button type="submit" class="w-full rounded-lg bg-amber-500 px-4 py-2 text-sm font-semibold text-black hover:bg-amber-400">
            Se connecter
        </button>
    </form>

    @if (Route::has('register'))
        <p class="mt-6 text-center text-sm text-white/60">
            Pas encore de compte ?
            <a href="{{ route('register') }}" class="font-semibold text-amber-300 hover:text-amber-200">Creer un compte</a>
        </p>
    @endif
</x-guest-layout>
