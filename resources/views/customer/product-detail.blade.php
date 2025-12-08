@extends('layouts.customer')

@section('title', $product->name . ' - UMKM Store')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <!-- Breadcrumb -->
        <nav class="mb-6">
            <ol class="flex items-center space-x-2 text-sm text-gray-600">
                <li><a href="{{ route('home') }}" class="hover:text-blue-600">Beranda</a></li>
                <li><span class="mx-2">/</span></li>
                <li><a href="{{ route('shop') }}" class="hover:text-blue-600">Toko</a></li>
                <li><span class="mx-2">/</span></li>
                <li><a href="{{ route('category.products', $product->category) }}"
                        class="hover:text-blue-600">{{ $product->category->name }}</a></li>
                <li><span class="mx-2">/</span></li>
                <li class="text-gray-900">{{ $product->name }}</li>
            </ol>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Product Image -->
            <div class="bg-white rounded-lg shadow-md p-6">
                @if ($product->image)
                    <img src="{{ asset($product->image) }}" alt="{{ $product->name }}"
                        class="w-full h-96 object-cover rounded-lg">
                @else
                    <div class="w-full h-96 bg-gray-200 rounded-lg flex items-center justify-center">
                        <span class="text-gray-500 text-lg">No Image</span>
                    </div>
                @endif
            </div>

            <!-- Product Info -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h1 class="text-3xl font-bold text-gray-800 mb-4">{{ $product->name }}</h1>

                <div class="mb-4">
                    <span class="text-sm text-gray-600">Kategori:</span>
                    <a href="{{ route('category.products', $product->category) }}"
                        class="text-blue-600 hover:text-blue-800 ml-2">{{ $product->category->name }}</a>
                </div>

                <div class="mb-6">
                    <span class="text-3xl font-bold text-blue-600">Rp
                        {{ number_format($product->price, 0, ',', '.') }}</span>
                </div>

                <div class="mb-6">
                    @if ($product->stock > 0)
                        <p class="text-green-600 font-medium mb-2">✓ Stok tersedia: {{ $product->stock }} unit</p>
                    @else
                        <p class="text-red-600 font-medium mb-2">✗ Stok habis</p>
                    @endif
                </div>

                @if ($product->description)
                    <div class="mb-6">
                        <h3 class="font-semibold text-gray-800 mb-2">Deskripsi Produk</h3>
                        <p class="text-gray-600 leading-relaxed">{{ $product->description }}</p>
                    </div>
                @endif

                @if ($product->stock > 0)
                    <form action="{{ route('cart.add') }}" method="POST" class="mb-6">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">

                        <div class="flex items-center space-x-4 mb-4">
                            <label for="quantity" class="font-medium text-gray-700">Jumlah:</label>
                            <input type="number" name="quantity" id="quantity" value="1" min="1"
                                max="{{ $product->stock }}"
                                class="w-20 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>

                        <button type="submit"
                            class="w-full bg-blue-600 text-white py-3 px-6 rounded-lg font-semibold hover:bg-blue-700 transition duration-300 mb-4">
                            + Tambah ke Keranjang
                        </button>
                    </form>
                @else
                    <button disabled
                        class="w-full bg-gray-400 text-white py-3 px-6 rounded-lg font-semibold cursor-not-allowed mb-4">
                        Stok Habis
                    </button>
                @endif

                <!-- Product Features -->
                <div class="border-t pt-6">
                    <h3 class="font-semibold text-gray-800 mb-4">Keunggulan</h3>
                    <ul class="space-y-2 text-sm text-gray-600">
                        <li class="flex items-center">
                            <svg class="w-4 h-4 text-green-500 mr-2" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                                </path>
                            </svg>
                            Produk berkualitas dari UMKM lokal
                        </li>
                        <li class="flex items-center">
                            <svg class="w-4 h-4 text-green-500 mr-2" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                                </path>
                            </svg>
                            Pengiriman cepat ke seluruh Indonesia
                        </li>
                        <li class="flex items-center">
                            <svg class="w-4 h-4 text-green-500 mr-2" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                                </path>
                            </svg>
                            Pembayaran aman (Transfer/COD)
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Related Products -->
        @if ($relatedProducts->count() > 0)
            <div class="mt-12">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Produk Terkait</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach ($relatedProducts as $relatedProduct)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition duration-300">
                            <a href="{{ route('product.detail', $relatedProduct) }}">
                                <div class="aspect-w-1 aspect-h-1">
                                    @if ($relatedProduct->image)
                                        <img src="{{ asset($relatedProduct->image) }}" alt="{{ $relatedProduct->name }}"
                                            class="w-full h-48 object-cover">
                                    @else
                                        <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                            <span class="text-gray-500">No Image</span>
                                        </div>
                                    @endif
                                </div>
                            </a>
                            <div class="p-4">
                                <a href="{{ route('product.detail', $relatedProduct) }}" class="block">
                                    <h3
                                        class="font-semibold text-gray-800 mb-2 hover:text-blue-600 transition duration-300">
                                        {{ $relatedProduct->name }}</h3>
                                </a>
                                <p class="text-sm text-gray-600 mb-2">{{ $relatedProduct->category->name }}</p>
                                <div class="flex justify-between items-center">
                                    <span class="text-lg font-bold text-blue-600">Rp
                                        {{ number_format($relatedProduct->price, 0, ',', '.') }}</span>
                                    @if ($relatedProduct->stock > 0)
                                        <form action="{{ route('cart.add') }}" method="POST" class="inline">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $relatedProduct->id }}">
                                            <input type="hidden" name="quantity" value="1">
                                            <button type="submit"
                                                class="bg-blue-600 text-white px-3 py-1 rounded text-sm hover:bg-blue-700 transition duration-300">
                                                + Keranjang
                                            </button>
                                        </form>
                                    @else
                                        <button disabled
                                            class="bg-gray-400 text-white px-3 py-1 rounded text-sm cursor-not-allowed">
                                            Stok Habis
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
@endsection
