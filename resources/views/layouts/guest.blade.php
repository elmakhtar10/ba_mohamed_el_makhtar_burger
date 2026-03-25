<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'ISI BURGER') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=space-grotesk:400,500,600,700" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-[#0f1115] text-white antialiased">
        <div class="relative min-h-screen overflow-hidden">
            <div class="absolute -top-32 -left-24 h-72 w-72 rounded-full bg-gradient-to-br from-amber-400/30 to-orange-600/20 blur-3xl"></div>
            <div class="absolute top-40 -right-24 h-80 w-80 rounded-full bg-gradient-to-br from-rose-500/30 to-red-700/20 blur-3xl"></div>

            <div class="mx-auto flex min-h-screen w-full max-w-5xl items-center justify-center px-6 py-12">
                <div class="w-full max-w-md">
                    <a href="/" class="flex items-center gap-3">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-amber-500 text-black font-bold">IB</div>
                        <div>
                            <p class="text-lg font-semibold tracking-tight">ISI BURGER</p>
                            <p class="text-xs text-white/60">Espace client & gestion</p>
                        </div>
                    </a>

                    <div class="mt-8 rounded-2xl border border-white/10 bg-white/5 p-6 shadow-xl">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
