@extends('layouts.customer')

@section('title', 'Toko - UMKM Store')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-4">Toko</h1>

            <!-- Search and Filter -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <form action="{{ route('shop') }}" method="GET" class="flex flex-col md:flex-row gap-4">
                    <div class="flex-1">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari produk..."
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>

                    <div class="md:w-48">
                        <select name="category"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Semua Kategori</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->slug }}"
                                    {{ request('category') == $category->slug ? 'selected' : '' }}>
                                    {{ $category->name }} ({{ $category->products_count }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="md:w-48">
                        <select name="sort"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                            <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Harga Terendah
                            </option>
                            <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Harga
                                Tertinggi</option>
                            <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Nama A-Z</option>
                        </select>
                    </div>

                    <button type="submit"
                        class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition duration-300">
                        Cari
                    </button>
                </form>
            </div>
        </div>

        <!-- Results Info -->
        <div class="mb-6">
            <p class="text-gray-600">
                Menampilkan {{ $products->count() }} dari {{ $products->total() }} produk
                @if (request('search'))
                    untuk "{{ request('search') }}"
                @endif
            </p>
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
                {{ $products->appends(request()->query())->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada produk ditemukan</h3>
                <p class="text-gray-500">Coba ubah filter pencarian Anda atau lihat semua produk.</p>
                <a href="{{ route('shop') }}"
                    class="mt-4 inline-block bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition duration-300">
                    Lihat Semua Produk
                </a>
            </div>
        @endif
    </div>
@endsection
