<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja kosong!');
        }

        $cartItems = [];
        $total = 0;

        foreach ($cart as $productId => $item) {
            $product = Product::find($productId);
            if ($product && $product->is_active) {
                $cartItems[] = [
                    'product' => $product,
                    'quantity' => $item['quantity'],
                    'subtotal' => $product->price * $item['quantity']
                ];
                $total += $product->price * $item['quantity'];
            }
        }

        if (empty($cartItems)) {
            return redirect()->route('cart.index')->with('error', 'Tidak ada produk valid di keranjang!');
        }

        return view('customer.checkout', compact('cartItems', 'total'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'city' => 'required|string|max:100',
            'postal_code' => 'required|string|max:10',
            'payment_method' => 'required|in:transfer,cod'
        ]);

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja kosong!');
        }

        try {
            DB::beginTransaction();

            // Calculate total
            $total = 0;
            $orderItems = [];

            foreach ($cart as $productId => $item) {
                $product = Product::find($productId);
                if (!$product || !$product->is_active) {
                    throw new \Exception('Produk tidak tersedia: ' . ($product ? $product->name : 'Unknown'));
                }

                if ($product->stock < $item['quantity']) {
                    throw new \Exception('Stok tidak mencukupi untuk produk: ' . $product->name);
                }

                $subtotal = $product->price * $item['quantity'];
                $total += $subtotal;

                $orderItems[] = [
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'price' => $product->price,
                    'subtotal' => $subtotal
                ];

                // Update stock
                $product->decrement('stock', $item['quantity']);
            }

            // Create order
            $order = Order::create([
                'user_id' => Auth::user()->id,
                'order_number' => 'ORD-' . date('Ymd') . '-' . strtoupper(uniqid()),
                'customer_name' => $request->name,
                'customer_email' => $request->email,
                'customer_phone' => $request->phone,
                'shipping_address' => $request->address,
                'shipping_city' => $request->city,
                'shipping_postal_code' => $request->postal_code,
                'total_amount' => $total,
                'payment_method' => $request->payment_method,
                'status' => $request->payment_method === 'cod' ? 'pending' : 'awaiting_payment'
            ]);

            // Create order items
            foreach ($orderItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'subtotal' => $item['subtotal']
                ]);
            }

            // Clear cart
            session()->forget('cart');

            DB::commit();

            return redirect()->route('customer.order.detail', $order)
                ->with('success', 'Pesanan berhasil dibuat! Nomor pesanan: ' . $order->order_number);
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
