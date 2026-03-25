<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatsController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $driver = DB::getDriverName();
        $ymExpr = $driver === 'pgsql'
            ? "TO_CHAR(created_at, 'YYYY-MM')"
            : "DATE_FORMAT(created_at, '%Y-%m')";
        $ymExprOrders = $driver === 'pgsql'
            ? "TO_CHAR(orders.created_at, 'YYYY-MM')"
            : "DATE_FORMAT(orders.created_at, '%Y-%m')";

        $year = (int) request('year', Carbon::now()->year);
        $month = request('month');
        $month = $month !== null && $month !== '' ? (int) $month : null;

        $firstOrderYear = Order::orderBy('created_at')->value('created_at');
        $minYear = $firstOrderYear ? Carbon::parse($firstOrderYear)->year : Carbon::now()->year;
        $maxYear = Carbon::now()->year;

        if ($month) {
            $periodStart = Carbon::createFromDate($year, $month, 1)->startOfMonth();
            $periodEnd = Carbon::createFromDate($year, $month, 1)->endOfMonth();
            $months = collect([$periodStart->format('Y-m')]);
            $periodLabel = $periodStart->format('m/Y');
        } else {
            $periodStart = Carbon::createFromDate($year, 1, 1)->startOfYear();
            $periodEnd = Carbon::createFromDate($year, 12, 31)->endOfYear();
            $months = collect(range(1, 12))->map(function ($m) use ($year) {
                return Carbon::createFromDate($year, $m, 1)->format('Y-m');
            });
            $periodLabel = (string) $year;
        }

        $ongoingCount = Order::whereBetween('created_at', [$periodStart, $periodEnd])
            ->whereNotIn('status', ['payee', 'annulee'])
            ->count();

        $validatedCount = Order::whereBetween('created_at', [$periodStart, $periodEnd])
            ->where('status', 'payee')
            ->count();

        $revenueTotal = Payment::whereBetween('paid_at', [$periodStart, $periodEnd])->sum('amount');

        $ordersPerMonthRaw = Order::selectRaw($ymExpr . " as ym, COUNT(*) as total")
            ->whereBetween('created_at', [$periodStart, $periodEnd])
            ->groupBy('ym')
            ->pluck('total', 'ym');

        $ordersPerMonth = $months->map(fn ($m) => (int) ($ordersPerMonthRaw[$m] ?? 0));

        $itemsByCategoryRaw = DB::table('order_items')
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->join('burgers', 'burgers.id', '=', 'order_items.burger_id')
            ->selectRaw($ymExprOrders . " as ym, COALESCE(burgers.category, 'Sans categorie') as category, SUM(order_items.quantity) as total")
            ->whereBetween('orders.created_at', [$periodStart, $periodEnd])
            ->groupBy('ym', 'category')
            ->get();

        $categories = $itemsByCategoryRaw->pluck('category')->unique()->values();

        $categorySeries = $categories->mapWithKeys(function ($category) use ($months, $itemsByCategoryRaw) {
            $data = $months->map(function ($m) use ($category, $itemsByCategoryRaw) {
                $row = $itemsByCategoryRaw->first(fn ($r) => $r->ym === $m && $r->category === $category);
                return (int) ($row->total ?? 0);
            });
            return [$category => $data];
        });

        return view('admin.stats', [
            'ongoingCount' => $ongoingCount,
            'validatedCount' => $validatedCount,
            'revenueTotal' => $revenueTotal,
            'months' => $months,
            'ordersPerMonth' => $ordersPerMonth,
            'categories' => $categories,
            'categorySeries' => $categorySeries,
            'periodLabel' => $periodLabel,
            'year' => $year,
            'month' => $month,
            'minYear' => $minYear,
            'maxYear' => $maxYear,
        ]);
    }
}
