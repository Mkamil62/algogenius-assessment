<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    /**
     * Display the analytics dashboard
     */
    public function index()
    {
        return view('dashboard');
    }

    public function getSummary()
    {
        // Cache summary data for 5 minutes
        $summary = Cache::remember('analytics_summary', 300, function () {
            $totalUsers = User::count();
            $totalOrders = Order::count();
            $totalRevenue = Order::sum('total_amount');
            $averageOrderValue = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;

            return [
                'total_users' => $totalUsers,
                'total_orders' => $totalOrders,
                'total_revenue' => round($totalRevenue, 2),
                'average_order_value' => round($averageOrderValue, 2),
            ];
        });

        return response()->json($summary);
    }

    public function getSalesTrend()
    {
        // Cache sales trend for 10 minutes
        $salesTrend = Cache::remember('analytics_sales_trend', 600, function () {
            $salesData = Order::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total_amount) as revenue')
            )
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

            $labels = [];
            $values = [];
            
            for ($i = 29; $i >= 0; $i--) {
                $date = now()->subDays($i)->format('Y-m-d');
                $labels[] = $date;
                
                $dayData = $salesData->firstWhere('date', $date);
                $values[] = $dayData ? round($dayData->revenue, 2) : 0;
            }

            return [
                'labels' => $labels,
                'values' => $values,
            ];
        });

        return response()->json($salesTrend);
    }

    public function getTopProducts()
    {
        // Cache top products for 10 minutes
        $topProducts = Cache::remember('analytics_top_products', 600, function () {
            $products = OrderItem::select(
                'product_id',
                DB::raw('SUM(price * quantity) as total_revenue'),
                DB::raw('SUM(quantity) as total_quantity')
            )
            ->with('product:id,name')
            ->groupBy('product_id')
            ->orderBy('total_revenue', 'desc')
            ->limit(5)
            ->get();

            $labels = [];
            $values = [];

            foreach ($products as $item) {
                $labels[] = $item->product->name;
                $values[] = round($item->total_revenue, 2);
            }

            return [
                'labels' => $labels,
                'values' => $values,
            ];
        });

        return response()->json($topProducts);
    }
}
