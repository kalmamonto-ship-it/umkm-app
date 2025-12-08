@extends('layouts.customer')

@section('title', $category->name . ' - UMKM Store')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <!-- Breadcrumb -->
        <nav class="mb-6">
            <ol class="flex items-center space-x-2 text-sm text-gray-600">
                <li><a href="{{ route('home') }}" class="hover:text-blue-600">Beranda</a></li>
                <li><span class="mx-2">/</span></li>
                <li><a href="{{ route('shop') }}" class="hover:text-blue-600">Toko</a></li>
                <li><span class="mx-2">/</span></li>
                <li class="text-gray-900">{{ $category->name }}</li>
            </ol>
        </nav>

        <!-- Category Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-4">{{ $category->name }}</h1>
            @if ($category->description)
                <p class="text-gray-600 mb-4">{{ $category->description }}</p>
            @endif
            <p class="text-gray-600">Menampilkan {{ $products->count() }} dari {{ $products->total() }} produk</p>
        </div>

        <!-- Products Grid -->
        @if ($products->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach ($products as $product)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition duration-300">
                        <a href="{{ route('product.detail', $product) }}">
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
                        </a>

                        <div class="p-4">
                            <a href="{{ route('product.detail', $product) }}" class="block">
                                <h3 class="font-semibold text-gray-800 mb-2 hover:text-blue-600 transition duration-300">
                                    {{ $product->name }}</h3>
                            </a>

                            <p class="text-sm text-gray-600 mb-2">{{ $product->category->name }}</p>

                            @if ($product->stock > 0)
                                <p class="text-sm text-green-600 mb-2">Stok: {{ $product->stock }}</p>
                            @else
                                <p class="text-sm text-red-600 mb-2">Stok Habis</p>
                            @endif

                            <div class="flex justify-between items-center">
                                <span class="text-lg font-bold text-blue-600">Rp
                                    {{ number_format($product->price, 0, ',', '.') }}</span>

                                @if ($product->stock > 0)
                                    <form action="{{ route('cart.add') }}" method="POST" class="inline">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
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

            <!-- Pagination -->
            <div class="mt-8">
                {{ $products->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada produk di kategori ini</h3>
                <p class="text-gray-500 mb-6">Belum ada produk yang tersedia dalam kategori {{ $category->name }}.</p>
                <a href="{{ route('shop') }}"
                    class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition duration-300">
                    Lihat Semua Produk
                </a>
            </div>
        @endif
    </div>
@endsection
