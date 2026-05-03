<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use App\Models\OrderItem;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Basic Stats
        $totalProducts = Product::count();
        $activeProducts = Product::where('status', 1)->count();
        $lowStockProducts = Product::where('stock', '<', 10)->where('stock', '>', 0)->count();
        $outOfStockProducts = Product::where('stock', 0)->count();

        // Order Stats
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', Order::PENDING)->count();
        $confirmedOrders = Order::where('status', Order::CONFIRMED)->count();
        $processedOrders = Order::where('status', Order::PROCESSING)->count();
        $shippedOrders = Order::where('status', Order::SHIPPED)->count();
        $deliveredOrders = Order::where('status', Order::COMPLETED)->count();
        $cancelledOrders = Order::where('status', Order::REJECTED)->count();

        // Revenue Stats
        $totalRevenue = Order::where('status', '!=', Order::REJECTED)->sum('total');
        $todayRevenue = Order::whereDate('created_at', Carbon::today())
                            ->where('status', '!=', Order::REJECTED)
                            ->sum('total');
        $monthRevenue = Order::whereMonth('created_at', Carbon::now()->month)
                            ->whereYear('created_at', Carbon::now()->year)
                            ->where('status', '!=', Order::REJECTED)
                            ->sum('total');

        // User Stats (users table stores customers)
        $totalCustomers = User::count();
        $todayCustomers = User::whereDate('created_at', Carbon::today())->count();
        $activeCustomers = User::where('is_active', '1')->count();

        // Recent Orders (last 10)
        $recentOrders = Order::with('user')
            ->latest()
            ->limit(10)
            ->get();

        // Top Selling Products with Product eager loaded
        $topProducts = OrderItem::select('product_id', \DB::raw('SUM(quantity) as total_sold'))
            ->groupBy('product_id')
            ->orderBy('total_sold', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($item) {
                $product = \App\Models\Product::find($item->product_id);
                return [
                    'product' => $product,
                    'total_sold' => $item->total_sold,
                    'product_name' => $product ? $product->name : 'Unknown Product',
                    'sku' => $product ? $product->sku : 'N/A'
                ];
            });

        // Sales Data for Chart (last 7 days)
        $last7Days = collect();
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $sales = Order::whereDate('created_at', $date)
                          ->where('status', '!=', Order::REJECTED)
                          ->sum('total');
            $ordersCount = Order::whereDate('created_at', $date)->count();
            $last7Days->push([
                'date' => $date->format('M d'),
                'sales' => $sales,
                'orders' => $ordersCount
            ]);
        }

        // Order Status Distribution
        $orderStatusData = [
            'pending' => $pendingOrders,
            'confirmed' => $confirmedOrders,
            'processing' => $processedOrders,
            'shipped' => $shippedOrders,
            'delivered' => $deliveredOrders,
            'cancelled' => $cancelledOrders
        ];

        // Status color map for charts and badges
        $statusColors = [
            'pending' => '#ffc107',
            'confirmed' => '#17a2b8',
            'processing' => '#007bff',
            'shipped' => '#6c757d',
            'delivered' => '#28a745',
            'cancelled' => '#dc3545'
        ];

        return view('admin.dashboard', compact(
            'totalProducts',
            'activeProducts',
            'lowStockProducts',
            'outOfStockProducts',
            'totalOrders',
            'pendingOrders',
            'confirmedOrders',
            'processedOrders',
            'shippedOrders',
            'deliveredOrders',
            'cancelledOrders',
            'totalRevenue',
            'todayRevenue',
            'monthRevenue',
            'totalCustomers',
            'todayCustomers',
            'activeCustomers',
            'recentOrders',
            'topProducts',
            'last7Days',
            'orderStatusData',
            'statusColors'
        ));
    }
}
