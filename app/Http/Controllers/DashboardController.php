<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function adminDashboard()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }
        
        // Get statistics
        $stats = [
            'total_sales' => Transaction::where('payment_status', 'completed')
                ->whereMonth('created_at', now()->month)
                ->sum('total_amount'),
            'total_transactions' => Transaction::whereMonth('created_at', now()->month)->count(),
            'total_products' => Product::count(),
            'total_users' => User::count(),
            
            // Growth percentages (comparing with last month)
            'sales_growth' => $this->calculateGrowth('transactions', 'total_amount'),
            'transactions_growth' => $this->calculateGrowth('transactions', 'count'),
            'products_growth' => $this->calculateGrowth('products', 'count'),
            'users_growth' => $this->calculateGrowth('users', 'count'),
        ];

        // Recent transactions
        $recentTransactions = Transaction::with(['user', 'cashier'])
            ->latest()
            ->take(5)
            ->get();

        // Recent users
        $recentUsers = User::latest()
            ->take(5)
            ->get();

        // Top products (sold quantity)
        $topProducts = DB::table('transactions')
            ->select(DB::raw('JSON_UNQUOTE(JSON_EXTRACT(items, "$[*].name")) as product_names'))
            ->where('payment_status', 'completed')
            ->get();

        // Sales chart data (last 6 months)
        $salesData = Transaction::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(total_amount) as total')
            )
            ->where('payment_status', 'completed')
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return view('dashboard.admin', compact('stats', 'recentTransactions', 'recentUsers', 'salesData'));
    }

    public function kasirDashboard()
    {
        if (auth()->user()->role !== 'kasir') {
            abort(403, 'Unauthorized action.');
        }
        
        return view('dashboard.kasir');
    }

    public function pembeliDashboard()
    {
        if (auth()->user()->role !== 'pembeli') {
            abort(403, 'Unauthorized action.');
        }
        
        return view('dashboard.pembeli');
    }

    private function calculateGrowth($table, $column)
    {
        if ($column === 'count') {
            $currentMonth = DB::table($table)
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count();

            $lastMonth = DB::table($table)
                ->whereMonth('created_at', now()->subMonth()->month)
                ->whereYear('created_at', now()->subMonth()->year)
                ->count();
        } else {
            $currentMonth = DB::table($table)
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->where('payment_status', 'completed')
                ->sum($column);

            $lastMonth = DB::table($table)
                ->whereMonth('created_at', now()->subMonth()->month)
                ->whereYear('created_at', now()->subMonth()->year)
                ->where('payment_status', 'completed')
                ->sum($column);
        }

        if ($lastMonth == 0) {
            return $currentMonth > 0 ? 100 : 0;
        }

        return round((($currentMonth - $lastMonth) / $lastMonth) * 100, 1);
    }

    // API endpoint untuk get stats
    public function getStats()
    {
        // Stats untuk dashboard kasir (hari ini)
        $today = now()->toDateString();
        $todaySales = Transaction::where('payment_status', 'completed')
            ->whereDate('created_at', $today)
            ->sum('total_amount');
        $todayTransactions = Transaction::whereDate('created_at', $today)->count();
        $todayItemsSold = Transaction::where('payment_status', 'completed')
            ->whereDate('created_at', $today)
            ->sum('total_items');
        $averageTransaction = $todayTransactions > 0 ? ($todaySales / $todayTransactions) : 0;

        $stats = [
            'today_sales' => $todaySales,
            'today_transactions' => $todayTransactions,
            'average_transaction' => $averageTransaction,
            'today_items_sold' => $todayItemsSold,
        ];

        return response()->json($stats);
    }

    // API endpoint untuk get sales chart data
    public function getSalesChartData(Request $request)
    {
        $period = $request->get('period', '6months'); // 7days, 30days, 6months
        
        if ($period === '7days') {
            // Last 7 days
            $salesData = Transaction::select(
                    DB::raw('DATE(created_at) as date'),
                    DB::raw('SUM(total_amount) as total')
                )
                ->where('payment_status', 'completed')
                ->where('created_at', '>=', now()->subDays(7))
                ->groupBy('date')
                ->orderBy('date')
                ->get();
            
            $labels = $salesData->map(function($item) {
                return \Carbon\Carbon::parse($item->date)->format('D');
            });
        } elseif ($period === '30days') {
            // Last 30 days (grouped by week)
            $salesData = Transaction::select(
                    DB::raw('WEEK(created_at) as week'),
                    DB::raw('SUM(total_amount) as total')
                )
                ->where('payment_status', 'completed')
                ->where('created_at', '>=', now()->subDays(30))
                ->groupBy('week')
                ->orderBy('week')
                ->get();
            
            $labels = $salesData->map(function($item, $index) {
                return 'Week ' . ($index + 1);
            });
        } else {
            // Last 6 months
            $salesData = Transaction::select(
                    DB::raw('MONTH(created_at) as month'),
                    DB::raw('YEAR(created_at) as year'),
                    DB::raw('SUM(total_amount) as total')
                )
                ->where('payment_status', 'completed')
                ->where('created_at', '>=', now()->subMonths(6))
                ->groupBy('year', 'month')
                ->orderBy('year')
                ->orderBy('month')
                ->get();
            
            $labels = $salesData->map(function($item) {
                $monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
                return $monthNames[$item->month - 1];
            });
        }
        
        $data = $salesData->pluck('total');
        
        return response()->json([
            'labels' => $labels,
            'data' => $data
        ]);
    }

    // API endpoint untuk pembeli stats
    public function getPembeliStats()
    {
        $userId = auth()->id();
        
        // Total purchases for this user
        $totalPurchases = Transaction::where('user_id', $userId)->count();
        
        // Total spending for this user
        $totalSpending = Transaction::where('user_id', $userId)
            ->where('payment_status', 'completed')
            ->sum('total_amount');
        
        // For favorites and rewards, we'll start with 0 (can be implemented later with proper tables)
        $favoriteCount = 0; // TODO: implement favorites table
        $rewardPoints = 0; // TODO: implement rewards table
        
        return response()->json([
            'total_purchases' => $totalPurchases,
            'total_spending' => $totalSpending,
            'favorite_count' => $favoriteCount,
            'reward_points' => $rewardPoints,
        ]);
    }
}
