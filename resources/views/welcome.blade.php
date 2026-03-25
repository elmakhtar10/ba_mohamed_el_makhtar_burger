<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'ISI BURGER') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=space-grotesk:400,500,600,700" rel="stylesheet" />

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
    </head>
    <body class="min-h-screen bg-[#0f1115] text-white antialiased">
        <div class="relative overflow-hidden">
            <div class="absolute -top-32 -left-24 h-72 w-72 rounded-full bg-gradient-to-br from-amber-400/40 to-orange-600/30 blur-3xl"></div>
            <div class="absolute top-32 -right-24 h-80 w-80 rounded-full bg-gradient-to-br from-rose-500/40 to-red-700/30 blur-3xl"></div>

            <div class="mx-auto max-w-6xl px-6 py-10">
                <header class="flex flex-wrap items-center justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-500/90 text-black font-bold">IB</div>
                        <div>
                            <p class="text-lg font-semibold tracking-tight">ISI BURGER</p>
                            <p class="text-xs text-white/70">Gestion des commandes</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ route('catalogue.index') }}" class="rounded-lg bg-amber-500 px-4 py-2 text-sm font-semibold text-black hover:bg-amber-400">Entrer</a>
                            @else
                                <a href="{{ route('login') }}" class="rounded-lg border border-white/20 px-4 py-2 text-sm font-semibold text-white hover:border-white/40">Login</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="rounded-lg bg-amber-500 px-4 py-2 text-sm font-semibold text-black hover:bg-amber-400">Register</a>
                                @endif
                            @endauth
                        @endif
                    </div>
                </header>

                <main class="mt-14 grid gap-10 lg:grid-cols-[1.1fr_0.9fr]">
                    <section class="space-y-6">
                        <p class="inline-flex items-center gap-2 rounded-full bg-white/10 px-3 py-1 text-xs text-white/80">
                            Burger shop commandes paiements
                        </p>
                        <h1 class="text-4xl font-bold leading-tight sm:text-5xl">
                            Gérez facilement les commandes
                            <span class="text-amber-400">ISI BURGER</span>
                        </h1>
                        <p class="text-base text-white/70 sm:text-lg">
                            Catalogue, prise de commande, suivi des statuts et paiements.
                            Une interface simple pour les clients et les gestionnaires.
                        </p>

                        <div class="flex flex-wrap items-center gap-3">
                            @auth
                                <a href="{{ route('catalogue.index') }}" class="rounded-lg bg-amber-500 px-5 py-3 text-sm font-semibold text-black hover:bg-amber-400">
                                    Voir le catalogue
                                </a>
                                <a href="{{ route('orders.index') }}" class="rounded-lg border border-white/20 px-5 py-3 text-sm font-semibold text-white hover:border-white/40">
                                    Mes commandes
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="rounded-lg bg-amber-500 px-5 py-3 text-sm font-semibold text-black hover:bg-amber-400">
                                    Se connecter
                                </a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="rounded-lg border border-white/20 px-5 py-3 text-sm font-semibold text-white hover:border-white/40">
                                        Creer un compte
                                    </a>
                                @endif
                            @endauth
                        </div>

                        <div class="grid gap-4 sm:grid-cols-3">
                            <div class="rounded-xl border border-white/10 bg-white/5 p-4">
                                <p class="text-sm font-semibold">Catalogue</p>
                                <p class="mt-1 text-xs text-white/70">Burgers disponibles, filtres par prix.</p>
                            </div>
                            <div class="rounded-xl border border-white/10 bg-white/5 p-4">
                                <p class="text-sm font-semibold">Commandes</p>
                                <p class="mt-1 text-xs text-white/70">Suivi des statuts en temps reel.</p>
                            </div>
                            <div class="rounded-xl border border-white/10 bg-white/5 p-4">
                                <p class="text-sm font-semibold">Paiements</p>
                                <p class="mt-1 text-xs text-white/70">Enregistrement simple et securise.</p>
                            </div>
                        </div>
                    </section>

                    <section class="relative">
                        <div class="rounded-3xl border border-white/10 bg-gradient-to-br from-white/10 via-white/5 to-white/0 p-6">
                            <div class="rounded-2xl bg-[#141822] p-6 shadow-lg">
                                <div class="flex items-center justify-between">
                                    <p class="text-sm font-semibold text-white/80">Flux de commande</p>
                                    <span class="rounded-full bg-amber-500/20 px-3 py-1 text-xs font-semibold text-amber-300">Automatique</span>
                                </div>
                                <div class="mt-4 space-y-3 text-sm text-white/70">
                                    <div class="flex items-center justify-between">
                                        <span>Commande client</span>
                                        <span>En attente</span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span>Preparation cuisine</span>
                                        <span>En preparation</span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span>Commande prete</span>
                                        <span>Facture PDF</span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span>Paiement enregistre</span>
                                        <span>Payee</span>
                                    </div>
                                </div>
                                <div class="mt-6 flex items-center justify-between border-t border-white/10 pt-4 text-sm font-semibold">
                                    <span>Gestionnaire notifie</span>
                                    <span class="text-amber-300">Email + App</span>
                                </div>
                            </div>
                        </div>
                    </section>
                </main>

                <footer class="mt-16 flex flex-wrap items-center justify-between gap-4 text-xs text-white/50">
                    <p>ISI BURGER - Projet Laravel</p>
                    <p>Gestion des commandes, paiements et livraisons</p>
                </footer>
            </div>
        </div>
    </body>
</html>
