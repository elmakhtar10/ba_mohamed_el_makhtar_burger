<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Statistiques
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6 rounded-lg bg-white p-4 shadow-sm">
                <form method="GET" action="{{ route('admin.stats') }}" class="flex flex-wrap items-center gap-3">
                    <label class="text-sm font-medium text-gray-700">Periode</label>
                    <select name="month" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">Toute l'annee</option>
                        @php
                            $monthLabels = [
                                1 => 'Janvier', 2 => 'Fevrier', 3 => 'Mars', 4 => 'Avril',
                                5 => 'Mai', 6 => 'Juin', 7 => 'Juillet', 8 => 'Aout',
                                9 => 'Septembre', 10 => 'Octobre', 11 => 'Novembre', 12 => 'Decembre',
                            ];
                        @endphp
                        @foreach($monthLabels as $m => $label)
                            <option value="{{ $m }}" @selected($month === $m)>{{ $label }}</option>
                        @endforeach
                    </select>
                    <select name="year" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @foreach(range($minYear, $maxYear) as $y)
                            <option value="{{ $y }}" @selected($year === $y)>{{ $y }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="rounded-md bg-gray-800 px-4 py-2 text-sm font-semibold text-white hover:bg-gray-700">
                        Filtrer
                    </button>
                </form>
            </div>

            <div class="grid gap-4 sm:grid-cols-3">
                <div class="rounded-lg bg-white p-4 shadow-sm">
                    <p class="text-sm text-gray-500">Commandes en cours ({{ $periodLabel }})</p>
                    <p class="mt-2 text-2xl font-semibold text-gray-800">{{ $ongoingCount }}</p>
                </div>
                <div class="rounded-lg bg-white p-4 shadow-sm">
                    <p class="text-sm text-gray-500">Commandes payees ({{ $periodLabel }})</p>
                    <p class="mt-2 text-2xl font-semibold text-gray-800">{{ $validatedCount }}</p>
                </div>
                <div class="rounded-lg bg-white p-4 shadow-sm">
                    <p class="text-sm text-gray-500">Recettes ({{ $periodLabel }})</p>
                    <p class="mt-2 text-2xl font-semibold text-gray-800">{{ number_format($revenueTotal, 2) }} FCFA</p>
                </div>
            </div>

            <div class="mt-8 grid gap-6 lg:grid-cols-2">
                <div class="rounded-lg bg-white p-4 shadow-sm">
                    <h3 class="text-sm font-semibold text-gray-700">Nombre de commandes par mois ({{ $periodLabel }})</h3>
                    <div class="mt-4">
                        <canvas id="ordersChart" height="140"></canvas>
                    </div>
                </div>

                <div class="rounded-lg bg-white p-4 shadow-sm">
                    <h3 class="text-sm font-semibold text-gray-700">Produits par categorie et par mois ({{ $periodLabel }})</h3>
                    <div class="mt-4">
                        <canvas id="categoryChart" height="140"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const months = @json($months);
        const ordersPerMonth = @json($ordersPerMonth);
        const categories = @json($categories);
        const categorySeries = @json($categorySeries);

        new Chart(document.getElementById('ordersChart'), {
            type: 'line',
            data: {
                labels: months,
                datasets: [{
                    label: 'Commandes',
                    data: ordersPerMonth,
                    borderColor: '#f59e0b',
                    backgroundColor: 'rgba(245, 158, 11, 0.2)',
                    fill: true,
                    tension: 0.3
                }]
            }
        });

        const colors = ['#22c55e', '#3b82f6', '#f97316', '#a855f7', '#ef4444', '#14b8a6'];
        const datasets = categories.map((cat, idx) => ({
            label: cat,
            data: categorySeries[cat] ?? [],
            borderColor: colors[idx % colors.length],
            backgroundColor: 'transparent',
            tension: 0.3
        }));

        new Chart(document.getElementById('categoryChart'), {
            type: 'line',
            data: {
                labels: months,
                datasets
            }
        });
    </script>
</x-app-layout>
