<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\PaymentConfirmation;
use App\Models\Product;
use App\Models\User;

class DashboardController extends Controller {
    public function index() {
        $totalRevenue = Order::whereIn('status', ['selesai', 'dikirim', 'diterima'])->sum('total');
        $totalOrders = Order::count();
        $totalProducts = Product::count();
        $totalUsers = User::where('role', 'user')->count();
        $recentOrders = Order::with(['user', 'items'])->latest()->take(10)->get();
        $pendingPayments = PaymentConfirmation::where('status', 'pending')->count();
        $orderStats = [
            'menunggu_bayar' => Order::where('status', 'menunggu_bayar')->count(),
            'diproses'       => Order::where('status', 'diproses')->count(),
            'dikirim'        => Order::where('status', 'dikirim')->count(),
            'selesai'        => Order::where('status', 'selesai')->count(),
        ];
        $monthlyRevenue = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $rev = Order::whereIn('status', ['selesai', 'dikirim', 'diterima'])
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->sum('total');
            $monthlyRevenue[] = ['month' => $date->format('M Y'), 'revenue' => $rev];
        }
        return view('admin.dashboard', compact('totalRevenue', 'totalOrders', 'totalProducts', 'totalUsers', 'recentOrders', 'pendingPayments', 'orderStats', 'monthlyRevenue'));
    }
}
