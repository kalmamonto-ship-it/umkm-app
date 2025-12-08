<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function home()
    {
        $featuredProducts = Product::with('category')
            ->where('is_featured', true)
            ->where('is_active', true)
            ->take(8)
            ->get();

        $categories = Category::withCount('products')->take(6)->get();

        return view('customer.home', compact('featuredProducts', 'categories'));
    }

    public function shop(Request $request)
    {
        $query = Product::with('category')->where('is_active', true);

        // Filter by category
        if ($request->has('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Search
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        // Sort
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'name':
                $query->orderBy('name', 'asc');
                break;
            default:
                $query->latest();
        }

        $products = $query->paginate(12);
        $categories = Category::withCount('products')->get();

        return view('customer.shop', compact('products', 'categories'));
    }

    public function productDetail(Product $product)
    {
        $relatedProducts = Product::with('category')
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->take(4)
            ->get();

        return view('customer.product-detail', compact('product', 'relatedProducts'));
    }

    public function categoryProducts(Category $category)
    {
        $products = Product::with('category')
            ->where('category_id', $category->id)
            ->where('is_active', true)
            ->paginate(12);

        return view('customer.category-products', compact('category', 'products'));
    }

    public function myOrders()
    {
        $orders = Order::where('user_id', Auth::user()->id)
            ->with('orderItems.product')
            ->latest()
            ->paginate(10);

        return view('customer.my-orders', compact('orders'));
    }

    public function orderDetail(Order $order)
    {
        // Ensure user can only view their own orders
        if ($order->user_id !== Auth::user()->id) {
            abort(403);
        }

        $order->load('orderItems.product');

        return view('customer.order-detail', compact('order'));
    }
}
