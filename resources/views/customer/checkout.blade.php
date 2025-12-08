@extends('layouts.customer')

@section('title', 'Checkout - UMKM Store')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-8">Checkout</h1>

        <form action="{{ route('checkout.process') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Checkout Form -->
                <div>
                    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Informasi Pengiriman</h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap
                                    *</label>
                                <input type="text" name="name" id="name"
                                    value="{{ old('name', auth()->user()->name ?? '') }}" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                @error('name')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                                <input type="email" name="email" id="email"
                                    value="{{ old('email', auth()->user()->email ?? '') }}" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                @error('email')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon
                                    *</label>
                                <input type="text" name="phone" id="phone" value="{{ old('phone') }}" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                @error('phone')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="city" class="block text-sm font-medium text-gray-700 mb-2">Kota *</label>
                                <input type="text" name="city" id="city" value="{{ old('city') }}" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                @error('city')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label for="postal_code" class="block text-sm font-medium text-gray-700 mb-2">Kode Pos
                                    *</label>
                                <input type="text" name="postal_code" id="postal_code" value="{{ old('postal_code') }}"
                                    required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                @error('postal_code')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Alamat Lengkap
                                    *</label>
                                <textarea name="address" id="address" rows="3" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('address') }}</textarea>
                                @error('address')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Payment Method -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Metode Pembayaran</h2>

                        <div class="space-y-3">
                            <label class="flex items-center">
                                <input type="radio" name="payment_method" value="transfer"
                                    {{ old('payment_method') == 'transfer' ? 'checked' : '' }} required
                                    class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                <span class="ml-3 text-gray-700">Transfer Bank</span>
                            </label>

                            <label class="flex items-center">
                                <input type="radio" name="payment_method" value="cod"
                                    {{ old('payment_method') == 'cod' ? 'checked' : '' }} required
                                    class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                <span class="ml-3 text-gray-700">Cash on Delivery (COD)</span>
                            </label>
                        </div>

                        @error('payment_method')
                            <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Order Summary -->
                <div>
                    <div class="bg-white rounded-lg shadow-md p-6 sticky top-4">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Ringkasan Pesanan</h2>

                        <!-- Order Items -->
                        <div class="space-y-4 mb-6">
                            @foreach ($cartItems as $item)
                                <div class="flex items-center space-x-3">
                                    <div class="flex-shrink-0">
                                        @if ($item['product']->image)
                                            <img src="{{ asset($item['product']->image) }}"
                                                alt="{{ $item['product']->name }}" class="w-12 h-12 object-cover rounded">
                                        @else
                                            <div class="w-12 h-12 bg-gray-200 rounded flex items-center justify-center">
                                                <span class="text-gray-500 text-xs">No Image</span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="font-medium text-gray-800">{{ $item['product']->name }}</h4>
                                        <p class="text-sm text-gray-600">{{ $item['quantity'] }} x Rp
                                            {{ number_format($item['product']->price, 0, ',', '.') }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-medium text-gray-800">Rp
                                            {{ number_format($item['subtotal'], 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Order Total -->
                        <div class="border-t pt-4 space-y-3">
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

                        <!-- Place Order Button -->
                        <button type="submit"
                            class="w-full bg-blue-600 text-white py-3 px-6 rounded-lg font-semibold hover:bg-blue-700 transition duration-300 mt-6">
                            Buat Pesanan
                        </button>

                        <!-- Back to Cart -->
                        <div class="mt-4 text-center">
                            <a href="{{ route('cart.index') }}" class="text-blue-600 hover:text-blue-800 text-sm">
                                ← Kembali ke Keranjang
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
