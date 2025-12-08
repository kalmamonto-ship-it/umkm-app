@extends('layouts.customer')

@section('title', 'Detail Pesanan #' . $order->order_number . ' - UMKM Store')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <!-- Breadcrumb -->
        <nav class="mb-6">
            <ol class="flex items-center space-x-2 text-sm text-gray-600">
                <li><a href="{{ route('home') }}" class="hover:text-blue-600">Beranda</a></li>
                <li><span class="mx-2">/</span></li>
                <li><a href="{{ route('customer.orders') }}" class="hover:text-blue-600">Pesanan Saya</a></li>
                <li><span class="mx-2">/</span></li>
                <li class="text-gray-900">Detail Pesanan</li>
            </ol>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Order Details -->
            <div class="lg:col-span-2">
                <!-- Order Header -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <div class="flex justify-between items-start">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-800 mb-2">Pesanan #{{ $order->order_number }}</h1>
                            <p class="text-gray-600">Dibuat pada {{ $order->created_at->format('d M Y H:i') }}</p>
                        </div>
                        <div class="text-right">
                            <span
                                class="inline-flex px-4 py-2 text-sm font-semibold rounded-full
                            @if ($order->status == 'pending') bg-yellow-100 text-yellow-800
                            @elseif($order->status == 'processing') bg-blue-100 text-blue-800
                            @elseif($order->status == 'shipped') bg-purple-100 text-purple-800
                            @elseif($order->status == 'delivered') bg-green-100 text-green-800
                            @elseif($order->status == 'cancelled') bg-red-100 text-red-800
                            @elseif($order->status == 'awaiting_payment') bg-orange-100 text-orange-800 @endif">
                                @switch($order->status)
                                    @case('pending')
                                        Menunggu Konfirmasi
                                    @break

                                    @case('processing')
                                        Sedang Diproses
                                    @break

                                    @case('shipped')
                                        Dikirim
                                    @break

                                    @case('delivered')
                                        Diterima
                                    @break

                                    @case('cancelled')
                                        Dibatalkan
                                    @break

                                    @case('awaiting_payment')
                                        Menunggu Pembayaran
                                    @break

                                    @default
                                        {{ ucfirst($order->status) }}
                                @endswitch
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Order Items -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Produk yang Dipesan</h2>
                    <div class="space-y-4">
                        @foreach ($order->orderItems as $item)
                            <div class="flex items-center space-x-4 p-4 border rounded-lg">
                                <div class="flex-shrink-0">
                                    @if ($item->product->image)
                                        <img src="{{ asset($item->product->image) }}" alt="{{ $item->product->name }}"
                                            class="w-20 h-20 object-cover rounded">
                                    @else
                                        <div class="w-20 h-20 bg-gray-200 rounded flex items-center justify-center">
                                            <span class="text-gray-500 text-xs">No Image</span>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-semibold text-gray-800">{{ $item->product->name }}</h3>
                                    <p class="text-sm text-gray-600">{{ $item->product->category->name }}</p>
                                    <p class="text-sm text-gray-600">{{ $item->quantity }} x Rp
                                        {{ number_format($item->price, 0, ',', '.') }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-semibold text-gray-800">Rp
                                        {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Shipping Information -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Informasi Pengiriman</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="font-medium text-gray-800 mb-2">Data Penerima</h3>
                            <div class="space-y-2 text-sm text-gray-600">
                                <p><strong>Nama:</strong> {{ $order->customer_name }}</p>
                                <p><strong>Email:</strong> {{ $order->customer_email }}</p>
                                <p><strong>Telepon:</strong> {{ $order->customer_phone }}</p>
                            </div>
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-800 mb-2">Alamat Pengiriman</h3>
                            <div class="space-y-2 text-sm text-gray-600">
                                <p>{{ $order->shipping_address }}</p>
                                <p>{{ $order->shipping_city }}</p>
                                <p>{{ $order->shipping_postal_code }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Information -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Informasi Pembayaran</h2>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Metode Pembayaran</span>
                            <span class="font-medium">
                                @if ($order->payment_method == 'transfer')
                                    Transfer Bank
                                @else
                                    Cash on Delivery (COD)
                                @endif
                            </span>
                        </div>
                        @if ($order->notes)
                            <div class="flex justify-between">
                                <span class="text-gray-600">Catatan</span>
                                <span class="font-medium">{{ $order->notes }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-md p-6 sticky top-4">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Ringkasan Pesanan</h2>

                    <div class="space-y-3 mb-6">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Subtotal</span>
                            <span class="font-medium">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Ongkos Kirim</span>
                            <span class="font-medium text-green-600">Gratis</span>
                        </div>
                        <hr>
                        <div class="flex justify-between text-lg font-bold">
                            <span>Total</span>
                            <span class="text-blue-600">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <!-- Status Timeline -->
                    <div class="border-t pt-6">
                        <h3 class="font-semibold text-gray-800 mb-4">Status Pesanan</h3>
                        <div class="space-y-3">
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-green-500 rounded-full mr-3"></div>
                                <span class="text-sm text-gray-600">Pesanan dibuat</span>
                                <span
                                    class="text-xs text-gray-400 ml-auto">{{ $order->created_at->format('d/m/Y H:i') }}</span>
                            </div>

                            @if ($order->status != 'pending' && $order->status != 'cancelled')
                                <div class="flex items-center">
                                    <div class="w-3 h-3 bg-green-500 rounded-full mr-3"></div>
                                    <span class="text-sm text-gray-600">Pesanan dikonfirmasi</span>
                                </div>
                            @endif

                            @if ($order->status == 'processing' || $order->status == 'shipped' || $order->status == 'delivered')
                                <div class="flex items-center">
                                    <div class="w-3 h-3 bg-green-500 rounded-full mr-3"></div>
                                    <span class="text-sm text-gray-600">Sedang diproses</span>
                                </div>
                            @endif

                            @if ($order->status == 'shipped' || $order->status == 'delivered')
                                <div class="flex items-center">
                                    <div class="w-3 h-3 bg-green-500 rounded-full mr-3"></div>
                                    <span class="text-sm text-gray-600">Dikirim</span>
                                </div>
                            @endif

                            @if ($order->status == 'delivered')
                                <div class="flex items-center">
                                    <div class="w-3 h-3 bg-green-500 rounded-full mr-3"></div>
                                    <span class="text-sm text-gray-600">Diterima</span>
                                </div>
                            @endif

                            @if ($order->status == 'cancelled')
                                <div class="flex items-center">
                                    <div class="w-3 h-3 bg-red-500 rounded-full mr-3"></div>
                                    <span class="text-sm text-gray-600">Dibatalkan</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="border-t pt-6 mt-6">
                        <a href="{{ route('customer.orders') }}"
                            class="w-full bg-gray-600 text-white py-2 px-4 rounded-lg font-medium hover:bg-gray-700 transition duration-300 text-center block mb-2">
                            Kembali ke Pesanan
                        </a>
                        <a href="{{ route('shop') }}"
                            class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg font-medium hover:bg-blue-700 transition duration-300 text-center block">
                            Belanja Lagi
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
