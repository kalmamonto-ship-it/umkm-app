<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'total_products' => Product::count(),
            'total_categories' => Category::count(),
            'total_orders' => Order::count(),
            'total_revenue' => Order::where('status', '!=', 'cancelled')->sum('total_amount'),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'featured_products' => Product::where('is_featured', true)->count(),
            'active_products' => Product::where('is_active', true)->count(),
        ];

        $recent_orders = Order::with('user')->latest()->take(5)->get();
        $featured_products = Product::with('category')->where('is_featured', true)->take(5)->get();
        $low_stock_products = Product::where('stock', '<', 10)->take(5)->get();

        return view('dashboard.index', compact('stats', 'recent_orders', 'featured_products', 'low_stock_products'));
    }
}
