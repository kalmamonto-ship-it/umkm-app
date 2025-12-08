@extends('layouts.customer')

@section('title', 'Beranda - UMKM Store')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <!-- Hero Section -->
        <div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-lg p-8 mb-8">
            <div class="text-center">
                <h1 class="text-4xl font-bold mb-4">Selamat Datang di UMKM Store</h1>
                <p class="text-xl mb-6">Temukan produk berkualitas dari UMKM lokal</p>
                <a href="{{ route('shop') }}"
                    class="bg-white text-blue-600 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 transition duration-300">
                    Mulai Belanja
                </a>
            </div>
        </div>

        <!-- Featured Products -->
        <section class="mb-12">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Produk Unggulan</h2>
                <a href="{{ route('shop') }}" class="text-blue-600 hover:text-blue-800 font-medium">Lihat Semua</a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach ($featuredProducts as $product)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition duration-300">
                        <div class="aspect-w-1 aspect-h-1">
                            @if ($product->image)
                                <img src="{{ asset($product->image) }}" alt="{{ $product->name }}"
                                    class="w-full h-48 object-cover">
                            @else
                                <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                    <span class="text-gray-500">No Image</span>
                                </div>
                            @endif
                        </div>
                        <div class="p-4">
                            <h3 class="font-semibold text-gray-800 mb-2">{{ $product->name }}</h3>
                            <p class="text-sm text-gray-600 mb-2">{{ $product->category->name }}</p>
                            <div class="flex justify-between items-center">
                                <span class="text-lg font-bold text-blue-600">Rp
                                    {{ number_format($product->price, 0, ',', '.') }}</span>
                                <form action="{{ route('cart.add') }}" method="POST" class="inline">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit"
                                        class="bg-blue-600 text-white px-3 py-1 rounded text-sm hover:bg-blue-700 transition duration-300">
                                        + Keranjang
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        <!-- Categories -->
        <section class="mb-12">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Kategori Produk</h2>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                @foreach ($categories as $category)
                    <a href="{{ route('category.products', $category) }}" class="block">
                        <div class="bg-white rounded-lg shadow-md p-4 text-center hover:shadow-lg transition duration-300">
                            @if ($category->image)
                                <img src="{{ asset($category->image) }}" alt="{{ $category->name }}"
                                    class="w-16 h-16 mx-auto mb-2 object-cover rounded">
                            @else
                                <div class="w-16 h-16 mx-auto mb-2 bg-gray-200 rounded flex items-center justify-center">
                                    <span class="text-gray-500 text-xs">{{ substr($category->name, 0, 2) }}</span>
                                </div>
                            @endif
                            <h3 class="font-medium text-gray-800">{{ $category->name }}</h3>
                            <p class="text-sm text-gray-600">{{ $category->products_count }} produk</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </section>

        <!-- Features -->
        <section class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="text-center">
                <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
                <h3 class="font-semibold text-gray-800 mb-2">Pengiriman Cepat</h3>
                <p class="text-gray-600">Pengiriman ke seluruh Indonesia</p>
            </div>

            <div class="text-center">
                <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="font-semibold text-gray-800 mb-2">Kualitas Terjamin</h3>
                <p class="text-gray-600">Produk berkualitas dari UMKM lokal</p>
            </div>

            <div class="text-center">
                <div class="bg-purple-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
                        </path>
                    </svg>
                </div>
                <h3 class="font-semibold text-gray-800 mb-2">Pembayaran Aman</h3>
                <p class="text-gray-600">Transfer bank atau COD</p>
            </div>
        </section>
    </div>
@endsection
