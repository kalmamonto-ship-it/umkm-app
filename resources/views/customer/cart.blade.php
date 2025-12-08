@extends('layouts.customer')

@section('title', 'Keranjang Belanja - UMKM Store')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-8">Keranjang Belanja</h1>

        @if (count($cartItems) > 0)
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Cart Items -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-lg shadow-md">
                        <div class="p-6 border-b">
                            <h2 class="text-xl font-semibold text-gray-800">Produk ({{ count($cartItems) }})</h2>
                        </div>

                        <div class="divide-y">
                            @foreach ($cartItems as $item)
                                <div class="p-6">
                                    <div class="flex items-center space-x-4">
                                        <!-- Product Image -->
                                        <div class="flex-shrink-0">
                                            @if ($item['product']->image)
                                                <img src="{{ asset($item['product']->image) }}"
                                                    alt="{{ $item['product']->name }}"
                                                    class="w-20 h-20 object-cover rounded-lg">
                                            @else
                                                <div
                                                    class="w-20 h-20 bg-gray-200 rounded-lg flex items-center justify-center">
                                                    <span class="text-gray-500 text-xs">No Image</span>
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Product Info -->
                                        <div class="flex-1">
                                            <h3 class="font-semibold text-gray-800 mb-1">{{ $item['product']->name }}</h3>
                                            <p class="text-sm text-gray-600 mb-2">{{ $item['product']->category->name }}</p>
                                            <p class="text-lg font-bold text-blue-600">Rp
                                                {{ number_format($item['product']->price, 0, ',', '.') }}</p>
                                        </div>

                                        <!-- Quantity Controls -->
                                        <div class="flex items-center space-x-2">
                                            <form action="{{ route('cart.update') }}" method="POST"
                                                class="flex items-center space-x-2">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="product_id" value="{{ $item['product']->id }}">
                                                <input type="number" name="quantity" value="{{ $item['quantity'] }}"
                                                    min="1" max="{{ $item['product']->stock }}"
                                                    class="w-16 px-2 py-1 border border-gray-300 rounded text-center">
                                                <button type="submit"
                                                    class="text-blue-600 hover:text-blue-800 text-sm">Update</button>
                                            </form>
                                        </div>

                                        <!-- Subtotal -->
                                        <div class="text-right">
                                            <p class="font-semibold text-gray-800">Rp
                                                {{ number_format($item['subtotal'], 0, ',', '.') }}</p>
                                        </div>

                                        <!-- Remove Button -->
                                        <div>
                                            <form action="{{ route('cart.remove') }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="product_id" value="{{ $item['product']->id }}">
                                                <button type="submit" class="text-red-600 hover:text-red-800">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                        </path>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Continue Shopping -->
                    <div class="mt-6">
                        <a href="{{ route('shop') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Lanjutkan Belanja
                        </a>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow-md p-6 sticky top-4">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Ringkasan Pesanan</h2>

                        <div class="space-y-3 mb-6">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Subtotal</span>
                                <span class="font-medium">Rp {{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Ongkos Kirim</span>
                                <span class="font-medium text-green-600">Gratis</span>
                            </div>
                            <hr>
                            <div class="flex justify-between text-lg font-bold">
                                <span>Total</span>
                                <span class="text-blue-600">Rp {{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <a href="{{ route('checkout.index') }}"
                            class="w-full bg-blue-600 text-white py-3 px-6 rounded-lg font-semibold hover:bg-blue-700 transition duration-300 text-center block">
                            Lanjut ke Pembayaran
                        </a>

                        <div class="mt-4 text-center">
                            <form action="{{ route('cart.clear') }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="text-red-600 hover:text-red-800 text-sm">
                                    Kosongkan Keranjang
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="text-center py-12">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6-5v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6m8 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v4.01">
                    </path>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Keranjang belanja kosong</h3>
                <p class="text-gray-500 mb-6">Belum ada produk di keranjang belanja Anda.</p>
                <a href="{{ route('shop') }}"
                    class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition duration-300">
                    Mulai Belanja
                </a>
            </div>
        @endif
    </div>
@endsection
