@extends('layouts.customer')

@section('title', 'Pesanan Saya - UMKM Store')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-8">Pesanan Saya</h1>

        @if ($orders->count() > 0)
            <div class="space-y-6">
                @foreach ($orders as $order)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <div class="p-6 border-b">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800">Pesanan #{{ $order->order_number }}</h3>
                                    <p class="text-sm text-gray-600">{{ $order->created_at->format('d M Y H:i') }}</p>
                                </div>
                                <div class="text-right">
                                    <span
                                        class="inline-flex px-3 py-1 text-sm font-semibold rounded-full
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

                        <div class="p-6">
                            <!-- Order Items -->
                            <div class="space-y-4 mb-6">
                                @foreach ($order->orderItems as $item)
                                    <div class="flex items-center space-x-4">
                                        <div class="flex-shrink-0">
                                            @if ($item->product->image)
                                                <img src="{{ asset($item->product->image) }}"
                                                    alt="{{ $item->product->name }}" class="w-16 h-16 object-cover rounded">
                                            @else
                                                <div class="w-16 h-16 bg-gray-200 rounded flex items-center justify-center">
                                                    <span class="text-gray-500 text-xs">No Image</span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex-1">
                                            <h4 class="font-medium text-gray-800">{{ $item->product->name }}</h4>
                                            <p class="text-sm text-gray-600">{{ $item->quantity }} x Rp
                                                {{ number_format($item->price, 0, ',', '.') }}</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="font-medium text-gray-800">Rp
                                                {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Order Details -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <div>
                                    <h4 class="font-semibold text-gray-800 mb-2">Informasi Pengiriman</h4>
                                    <div class="text-sm text-gray-600 space-y-1">
                                        <p><strong>Nama:</strong> {{ $order->customer_name }}</p>
                                        <p><strong>Email:</strong> {{ $order->customer_email }}</p>
                                        <p><strong>Telepon:</strong> {{ $order->customer_phone }}</p>
                                        <p><strong>Alamat:</strong> {{ $order->shipping_address }}</p>
                                        <p><strong>Kota:</strong> {{ $order->shipping_city }}</p>
                                        <p><strong>Kode Pos:</strong> {{ $order->shipping_postal_code }}</p>
                                    </div>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-800 mb-2">Informasi Pembayaran</h4>
                                    <div class="text-sm text-gray-600 space-y-1">
                                        <p><strong>Metode:</strong>
                                            @if ($order->payment_method == 'transfer')
                                                Transfer Bank
                                            @else
                                                Cash on Delivery (COD)
                                            @endif
                                        </p>
                                        <p><strong>Total:</strong> Rp
                                            {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                                        @if ($order->notes)
                                            <p><strong>Catatan:</strong> {{ $order->notes }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex justify-between items-center">
                                <a href="{{ route('customer.order.detail', $order) }}"
                                    class="text-blue-600 hover:text-blue-800 font-medium">
                                    Lihat Detail
                                </a>
                                <div class="text-right">
                                    <p class="text-lg font-bold text-blue-600">Total: Rp
                                        {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $orders->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                    </path>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada pesanan</h3>
                <p class="text-gray-500 mb-6">Anda belum memiliki pesanan. Mulai belanja sekarang!</p>
                <a href="{{ route('shop') }}"
                    class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition duration-300">
                    Mulai Belanja
                </a>
            </div>
        @endif
    </div>
@endsection
