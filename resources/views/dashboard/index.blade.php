@extends('layouts.app')

@section('title', 'Dashboard - Aplikasi UMKM')
@section('page-title', 'Dashboard')

@section('content')
<div class="row">
    <!-- Statistics Cards -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stats-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="mb-1">{{ number_format($stats['total_users']) }}</h3>
                    <p class="mb-0 opacity-75">Total Pengguna</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stats-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="mb-1">{{ number_format($stats['total_products']) }}</h3>
                    <p class="mb-0 opacity-75">Total Produk</p>
                </div>
                <div class="icon">
                    <i class="fas fa-box"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stats-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="mb-1">{{ number_format($stats['total_orders']) }}</h3>
                    <p class="mb-0 opacity-75">Total Pesanan</p>
                </div>
                <div class="icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stats-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="mb-1">Rp {{ number_format($stats['total_revenue']) }}</h3>
                    <p class="mb-0 opacity-75">Total Pendapatan</p>
                </div>
                <div class="icon">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Recent Orders -->
    <div class="col-lg-8 mb-4">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0">
                    <i class="fas fa-clock me-2"></i>
                    Pesanan Terbaru
                </h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>No. Pesanan</th>
                                <th>Pelanggan</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recent_orders as $order)
                            <tr>
                                <td>
                                    <a href="{{ route('orders.show', $order->id) }}" class="text-decoration-none">
                                        {{ $order->order_number }}
                                    </a>
                                </td>
                                <td>{{ $order->customer_name }}</td>
                                <td>Rp {{ number_format($order->total_amount) }}</td>
                                <td>
                                    @switch($order->status)
                                        @case('pending')
                                            <span class="badge bg-warning">Pending</span>
                                            @break
                                        @case('processing')
                                            <span class="badge bg-info">Diproses</span>
                                            @break
                                        @case('shipped')
                                            <span class="badge bg-primary">Dikirim</span>
                                            @break
                                        @case('delivered')
                                            <span class="badge bg-success">Diterima</span>
                                            @break
                                        @case('cancelled')
                                            <span class="badge bg-danger">Dibatalkan</span>
                                            @break
                                    @endswitch
                                </td>
                                <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-4">
                                    <i class="fas fa-inbox fa-2x text-muted mb-2"></i>
                                    <p class="text-muted mb-0">Belum ada pesanan</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Quick Stats -->
    <div class="col-lg-4 mb-4">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0">
                    <i class="fas fa-chart-pie me-2"></i>
                    Statistik Cepat
                </h5>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span>Pesanan Pending</span>
                    <span class="badge bg-warning">{{ $stats['pending_orders'] }}</span>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span>Produk Unggulan</span>
                    <span class="badge bg-success">{{ $stats['featured_products'] }}</span>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span>Produk Aktif</span>
                    <span class="badge bg-primary">{{ $stats['active_products'] }}</span>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <span>Kategori</span>
                    <span class="badge bg-info">{{ $stats['total_categories'] }}</span>
                </div>
            </div>
        </div>
        
        <!-- Low Stock Alert -->
        @if($low_stock_products->count() > 0)
        <div class="card mt-4">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0 text-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Stok Menipis
                </h5>
            </div>
            <div class="card-body">
                @foreach($low_stock_products as $product)
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="text-truncate">{{ $product->name }}</span>
                    <span class="badge bg-danger">{{ $product->stock }}</span>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>

<div class="row">
    <!-- Featured Products -->
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0">
                    <i class="fas fa-star me-2"></i>
                    Produk Unggulan
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    @forelse($featured_products as $product)
                    <div class="col-md-3 col-sm-6 mb-3">
                        <div class="card h-100">
                            @if($product->image)
                                <img src="{{ asset($product->image) }}" class="card-img-top" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                            @else
                                <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                    <i class="fas fa-image fa-3x text-muted"></i>
                                </div>
                            @endif
                            <div class="card-body">
                                <h6 class="card-title">{{ $product->name }}</h6>
                                <p class="card-text text-muted small">{{ $product->category->name }}</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="fw-bold text-primary">Rp {{ number_format($product->price) }}</span>
                                    <span class="badge bg-secondary">{{ $product->stock }} stok</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12 text-center py-4">
                        <i class="fas fa-star fa-2x text-muted mb-2"></i>
                        <p class="text-muted mb-0">Belum ada produk unggulan</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
